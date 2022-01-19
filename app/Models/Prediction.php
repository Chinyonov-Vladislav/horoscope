<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    use HasFactory;
    protected $fillable=['text_prediction','date_usage','id_sign_fk'];
    public function signs_zodiaks()
    {
        return $this->belongsTo(signs_zodiak::class);
    }
}
