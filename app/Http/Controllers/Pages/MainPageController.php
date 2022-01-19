<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainPageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $znak_zodiacs = DB::table('signs_zodiaks')
            ->select('id', "name_znak", 'image_link', 'start_interval_date', 'finish_interval_date')
            ->get();

        $count_prediction_on_today = DB::table('predictions')
            ->where('date_usage', '=', Carbon::now()->format('Y-m-d'))
            ->count();
        if ($count_prediction_on_today == 0) {
            $count_free_prediction = DB::table('predictions')
                ->where('id_sign_fk', '=', null)
                ->where('date_usage', '=', null)
                ->count();
            if ($count_free_prediction >= count($znak_zodiacs)) {
                foreach ($znak_zodiacs as $sign) {
                    $index_prediction = DB::table('predictions')
                        ->where('date_usage', '=', null)
                        ->orderByRaw('RAND()')
                        ->select('id')
                        ->first()
                        ->id;
                    DB::table('predictions')
                        ->where('id', '=', $index_prediction)
                        ->update(['id_sign_fk' => $sign->id, 'date_usage' => Carbon::now()->format('Y-m-d')]);
                }
            } else {
                // недостаточно предсказаний в бд, чтобы заполнить его на сегодня
            }
        } else {
            //уже есть предсказания на сегодня
        }
        $all_info_signs_today = DB::table('predictions')
            ->rightJoin('signs_zodiaks', 'predictions.id_sign_fk', '=', 'signs_zodiaks.id')
            ->where('predictions.date_usage', '=', Carbon::now()->format('Y-m-d'))
            ->select('signs_zodiaks.id', 'signs_zodiaks.name_znak', 'signs_zodiaks.image_link', 'signs_zodiaks.start_interval_date', 'signs_zodiaks.finish_interval_date', 'predictions.text_prediction')
            ->orderBy('signs_zodiaks.id')
            ->get();
        if (count($all_info_signs_today)!==count($znak_zodiacs))
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
        return view("pages/mainPage", compact('user', 'all_info_signs_today'));
    }
}
