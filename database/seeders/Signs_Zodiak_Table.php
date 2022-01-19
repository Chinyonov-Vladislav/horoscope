<?php

namespace Database\Seeders;

use App\Models\signs_zodiak;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class Signs_Zodiak_Table extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $signs = [
            ['name_znak'=>'Овен','image_link'=>'images/oven.png','start_interval_date'=>Carbon::create(Carbon::now()->year,3,21),'finish_interval_date'=>Carbon::create(Carbon::now()->year,4,20)],
            ['name_znak'=>'Телец','image_link'=>'images/telec.png','start_interval_date'=>Carbon::create(Carbon::now()->year,4,21),'finish_interval_date'=>Carbon::create(Carbon::now()->year,5,21)],
            ['name_znak'=>'Близнецы','image_link'=>'images/blizneci.png','start_interval_date'=>Carbon::create(Carbon::now()->year,5,22),'finish_interval_date'=>Carbon::create(Carbon::now()->year,6,21)],
            ['name_znak'=>'Рак','image_link'=>'images/rak.png','start_interval_date'=>Carbon::create(Carbon::now()->year,6,22),'finish_interval_date'=>Carbon::create(Carbon::now()->year,7,22)],
            ['name_znak'=>'Лев','image_link'=>'images/lev.png','start_interval_date'=>Carbon::create(Carbon::now()->year,7,23),'finish_interval_date'=>Carbon::create(Carbon::now()->year,8,23)],
            ['name_znak'=>'Дева','image_link'=>'images/deva.png','start_interval_date'=>Carbon::create(Carbon::now()->year,8,24),'finish_interval_date'=>Carbon::create(Carbon::now()->year,9,23)],
            ['name_znak'=>'Весы','image_link'=>'images/vesi.png','start_interval_date'=>Carbon::create(Carbon::now()->year,9,24),'finish_interval_date'=>Carbon::create(Carbon::now()->year,10,23)],
            ['name_znak'=>'Скорпион','image_link'=>'images/skorpion.png','start_interval_date'=>Carbon::create(Carbon::now()->year,10,24),'finish_interval_date'=>Carbon::create(Carbon::now()->year,11,22)],
            ['name_znak'=>'Стрелец','image_link'=>'images/strelec.png','start_interval_date'=>Carbon::create(Carbon::now()->year,11,23),'finish_interval_date'=>Carbon::create(Carbon::now()->year,12,22)],
            ['name_znak'=>'Козерог','image_link'=>'images/kozerog.png','start_interval_date'=>Carbon::create(Carbon::now()->year,12,23),'finish_interval_date'=>Carbon::create(Carbon::now()->year,1,20)],
            ['name_znak'=>'Водолей','image_link'=>'images/vodolei.png','start_interval_date'=>Carbon::create(Carbon::now()->year,1,21),'finish_interval_date'=>Carbon::create(Carbon::now()->year,2,19)],
            ['name_znak'=>'Рыбы','image_link'=>'images/ribi.png','start_interval_date'=>Carbon::create(Carbon::now()->year,2,20),'finish_interval_date'=>Carbon::create(Carbon::now()->year,3,20)],
        ];
        foreach ($signs as $sign) {
            signs_zodiak::create([
                'name_znak' => $sign['name_znak'],
                'image_link' => $sign['image_link'],
                'start_interval_date' => $sign['start_interval_date'],
                'finish_interval_date' => $sign['finish_interval_date'],
            ]);
        }
    }
}
