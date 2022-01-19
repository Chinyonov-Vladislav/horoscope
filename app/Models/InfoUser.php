<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoUser extends Model
{
    use HasFactory;
    protected $fillable=[
        'number_phone',
        'address',
        'about_me',
        'profession',
        'id_user_fk'
    ];
    private function User()
    {
        return $this->belongsTo(User::class);
    }
}
