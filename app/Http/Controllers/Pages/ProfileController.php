<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Hamcrest\BaseDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function changePasswordView()
    {
        if (Auth::check())
        {
            $user = Auth::user();
            return view('pages/changePasswordPage',compact('user'));
        }
        else
        {
            return redirect('/');
        }
    }
    public function index()
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $info_user = DB::table('users')
                ->join('info_users','users.id','=','info_users.id_user_fk')
                ->select('users.name','users.email','info_users.address', 'info_users.profession','info_users.number_phone','info_users.about_me')
                ->where('id_user_fk','=',Auth::id())
                ->get();
            return view('pages/profilePage',compact('user','info_user'));
        }
        else
        {
            return redirect('/');
        }
    }
    public function ResetPassword(Request $request)
    {

        try {
            $messages = [
                'required' => 'Поле :attribute является обязательным и не может быть пустым!',
                'email'=>'Поле :attribute не яляется email-адресом'
            ];
            $rules= ['email'=>'required|email'];
            $validator = Validator::make($request->all(),$rules,$messages);
            if($validator->fails())
            {
                return response()->json(["Error_Validation"=>true, 'Message'=>$validator->errors()]);
            }
            $count_email=DB::table('users')
                ->where('email','=',$request->email)
                ->count();
            if ($count_email!=1)
            {
                return response()->json(["Success"=>false, 'Message'=>"Не найден email-адрес, для которого было запрошено восстановление пароля"]);
            }
            else
            {
                $new_password = Str::random(8);
                DB::table('users')
                    ->where('email','=',$request->email)
                    ->update(['password'=>Hash::make($new_password)]);
                $data=array('password'=>$new_password);
                $to_name = DB::table('users')
                    ->where('email','=',$request->email)
                    ->select('name')
                    ->first()
                    ->name;
                $to_email=$request->email;
                Mail::send('mail',$data,function ($message) use ($to_name, $to_email){
                    $message->to($to_email,$to_name)
                        ->subject("Новый пароль для авторизации на сайте гороскопа");
                    $message->from('horoscope.online.every.day@gmail.com','Horoscope online');
                });
                return response()->json(['Success'=>true, 'Message'=>'Новый пароль для аутентификации был отправлен на почту']);
            }
        }
        catch (\Exception $exception)
        {
            return response()->json(['Success'=>false, 'Message'=>"Ошибка сервера!"]);
        }

    }
    public function changePassword(Request $request)
    {
        try {
            $id_user = Auth::id();
            $old_hash_password = DB::table('users')->where('id','=',$id_user)->select('password')->first()->password;
            if (password_verify($request->old_password, $old_hash_password))
            {
                $new_hash_password = Hash::make($request->new_password);
                $to_email = DB::table('users')
                    ->where('id','=',$id_user)
                    ->select('email')
                    ->first()
                    ->email;
                $to_name = DB::table('users')
                    ->where('id','=',$id_user)
                    ->select('name')
                    ->first()
                    ->name;
                DB::table('users')->where('id','=',$id_user)
                    ->update(['password'=>$new_hash_password]);
                $data=array('password'=>$request->new_password);
                Mail::send('mail',$data,function ($message) use ($to_name, $to_email){
                    $message->to($to_email,$to_name)
                        ->subject("Новый пароль для авторизации на сайте гороскопа");
                    $message->from('horoscope.online.every.day@gmail.com','Horoscope online');
                });
                return response()->json(["Success"=>true, "Message"=>"Новый пароль для аутентификации сменён и был выслан на почту"]);
            }
            else
            {
                return response()->json(["Success"=>false, "Message"=>'Старый пароль не соотвествует вашему паролю!']);
            }
        }
        catch (\Exception $exception)
        {
            logger($exception);
            return response()->json(['Success'=>false, 'Message'=>"Произошла ошибка на сервере!"]);
        }
    }
}
