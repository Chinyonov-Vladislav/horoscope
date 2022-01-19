<?php

namespace App\Http\Controllers\Pages;

use App\Exports\PredictionsExport;
use App\Http\Controllers\Controller;
use App\Models\Prediction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;
use phpDocumentor\Reflection\Types\False_;

class PredictionsController extends Controller
{
    public function index($number_page)
    {
        try {
            if (Auth::check()) {
                $count_items_on_page = 50;
                $count_all_items = DB::table('predictions')
                    ->count();
                $count_all_pages = (int)($count_all_items / $count_items_on_page);
                if ($count_all_items % $count_items_on_page > 0) {
                    $count_all_pages += 1;
                }
                $user = Auth::user();
                $predictions = DB::table('predictions')->select(['id', 'text_prediction', 'date_usage'])->skip($count_items_on_page * ($number_page - 1))->take($count_items_on_page)->get();
                foreach ($predictions as $prediction) {
                    if ($prediction->date_usage != null) {
                        $prediction->date_usage = Carbon::parse($prediction->date_usage)->format('d.m.y');
                    }
                }
                return view('pages/predictionsPage', compact('user', 'predictions', 'number_page', 'count_all_pages'));
            } else {
                return redirect('/');
            }
        } catch (\Exception $exception) {
            logger($exception);
            return response()->json(['Success' => false]);
        }
    }

    public function addNewPrediction()
    {
        $user = Auth::user();
        $prediction = "";
        $type_action = true;
        return view('pages/actionWithPredictionPage', compact('user', 'type_action', 'prediction'));
    }

    public function addNewPredictionToDatabase(Request $request)
    {
        try {
            //$validated_data = $request->validate(['text_prediction'=>'required|unique:predictions']);
            $messages = [
                'required' => 'Поле :attribute является обязательным и не может быть пустым!',
                'unique' => 'Предсказание должно быть уникальным!'
            ];
            $rules = ['text_prediction' => 'required|unique:predictions|max:5000'];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json(["Error_Validation" => true, 'Message' => $validator->errors()]);
            }
            $validated_data = $validator->validated();
            DB::table('predictions')
                ->insert($validated_data);
            return response()->json(['Success' => true]);
        } catch (\Exception $exception) {
            logger($exception);
            return response()->json(['Success' => false, "Message" => "Произошла ошибка на сервере!"]);
        }
    }

    public function DeletePrediction($id, Request $request)
    {
        try {
            DB::table('predictions')->where('id', '=', $id)->delete();
            $count_items_on_page = 50;
            $count_all_items = DB::table('predictions')
                ->count();
            $count_all_pages = (int)($count_all_items / $count_items_on_page);
            if ($count_all_items % $count_items_on_page > 0) {
                $count_all_pages += 1;
            }
            $number_page = null;
            $predictions = null;
            if ($count_all_pages==0)
            {
                $number_page = 1;
                $predictions = DB::table('predictions')->select(['id', 'text_prediction', 'date_usage'])->skip($count_items_on_page * ($number_page- 1))->take($count_items_on_page)->get();
            }
            elseif($count_all_pages>0)
            {
                if ($count_all_pages==$request->all_count_page)
                {
                    $number_page=$request->current_page;
                    $count_all_pages = $request->all_count_page;
                    $predictions = DB::table('predictions')->select(['id', 'text_prediction', 'date_usage'])->skip($count_items_on_page * ($number_page- 1))->take($count_items_on_page)->get();
                }
                else
                {
                    if ($request->current_page== $request->all_count_page)
                    {
                        $number_page = $request->current_page-1;
                        $predictions = DB::table('predictions')->select(['id', 'text_prediction', 'date_usage'])->skip($count_items_on_page * ($number_page- 1))->take($count_items_on_page)->get();
                    }
                    elseif($request->current_page < $request->all_count_page)
                    {
                        $number_page = $request->current_page;
                        $predictions = DB::table('predictions')->select(['id', 'text_prediction', 'date_usage'])->skip($count_items_on_page * ($number_page- 1))->take($count_items_on_page)->get();
                    }
                }
            }
            return response()->json(["Success" => true, "Number_page"=>$number_page, "Count_all_pages"=>$count_all_pages,'Predictions'=>$predictions]);
        } catch (\Exception $exception) {
            return response()->json(['Success' => false, "Message" => "Произошла ошибка при удалении"]);
        }
    }

    public function RedactPrediction($id)
    {
        $user = Auth::user();
        $type_action = false;
        $prediction = DB::table('predictions')->select('id', "text_prediction")->where('id', '=', $id)->get();
        return view('pages/actionWithPredictionPage', compact('user', 'type_action', 'prediction'));
    }

    public function SaveRedactPrediction(Request $request)
    {
        try {
            $messages = [
                'required' => 'Поле :attribute является обязательным и не может быть пустым!',
                'unique' => 'Предсказание должно быть уникальным!'
            ];
            $rules = ['text_prediction' => 'required|unique:predictions|max:5000'];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json(["Error_Validation" => true, 'Message' => $validator->errors()]);
            }
            $validated_data = $validator->validated();
            DB::table('predictions')
                ->where('id','=',$request->id_prediction)
                ->update($validated_data);
            return response()->json(['Success' => true]);
        } catch (\Exception $exception) {
            return response()->json(['Success' => false]);
        }
    }
    public function DownloadExcel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new PredictionsExport,"predictions ".Carbon::now()->format('d_m_Y h_i_s').'.xlsx');
    }
    public function showPredictionByDay(Request $request)
    {
        try {
            $znak_zodiacs = DB::table('signs_zodiaks')
                ->select('id', "name_znak", 'image_link', 'start_interval_date', 'finish_interval_date')
                ->get();
            $all_info_signs_today = DB::table('predictions')
                ->rightJoin('signs_zodiaks', 'predictions.id_sign_fk', '=', 'signs_zodiaks.id')
                ->where('predictions.date_usage', '=', Carbon::parse($request->date_from_calendar)->format('Y-m-d'))
                ->select('signs_zodiaks.id', 'signs_zodiaks.name_znak', 'signs_zodiaks.image_link', 'signs_zodiaks.start_interval_date', 'signs_zodiaks.finish_interval_date', 'predictions.text_prediction')
                ->orderBy('signs_zodiaks.id')
                ->get();
            if(count($all_info_signs_today)!==count($znak_zodiacs))
            {
                $all_info_signs_today = DB::table('signs_zodiaks')
                    ->select('id', "name_znak", 'image_link', 'start_interval_date', 'finish_interval_date')
                    ->get();
                foreach ($all_info_signs_today as $sign) {
                    $sign->text_prediction = null;
                }
            }
            foreach ($all_info_signs_today as $sign) {
                $sign->start_interval_date = Carbon::parse($sign->start_interval_date)->format('d.m.y');
                $sign->finish_interval_date = Carbon::parse($sign->finish_interval_date)->format('d.m.y');
            }
            $formated_date = date('d.m.Y', strtotime($request->date_from_calendar));
            return response()->json(['Success'=>true,"Info_about_signs_date"=>$all_info_signs_today, 'formated_date'=>$formated_date]);

        } catch (\Exception $exception)
        {
            logger($exception);
            return response()->json(['Success'=>false,'Message'=>"Произошла ошибка на сервере"]);
        }
    }
}
