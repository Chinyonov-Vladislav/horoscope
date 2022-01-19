<?php

namespace App\Exports;

use App\Models\Prediction;
use Maatwebsite\Excel\Concerns\FromCollection;

class PredictionsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Prediction::all();
    }
}
