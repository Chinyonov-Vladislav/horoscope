<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InfoAboutUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pages/infoAboutUserAfterRegistration', compact('user'));
    }
    public function addNewInfo(Request $request)
    {
        try {
            DB::table('info_users')->insert([
                'number_phone'=>$request['number_phone'],
                'address'=>$request['address'],
                'profession'=>$request['profession'],
                'about_me'=>$request['about_me'],
                'id_user_fk'=>Auth::id(),
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            return response()->json(["Success"=>true]);
        }
        catch (\Exception $exception)
        {
            return response()->json(["Success"=>false,'Message'=>'Произошла ошибка']);
        }
    }
    public function redactInfo(Request $request)
    {
        try {
            DB::table('users')
                ->update(['name'=>$request['nickname']]);
            DB::table('info_users')
                ->update(['address'=>$request['address'],'about_me'=>$request['about_me'],'number_phone'=>$request['number_phone'],'profession'=>$request['profession']]);
            return response()->json(['Success'=>true]);
        }
        catch (\Exception $exception)
        {
            return response()->json(["Success"=>false,'Message'=>'Произошла ошибка']);
        }
    }
}
