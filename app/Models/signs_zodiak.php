<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class signs_zodiak extends Model
{
    use HasFactory;
    protected $fillable=[
      'name_znak',
      'image_link',
      'start_interval_date',
      'finish_interval_date',
    ];
    public function Prediction()
    {
        return $this->hasMany(Prediction::class);
    }
}
