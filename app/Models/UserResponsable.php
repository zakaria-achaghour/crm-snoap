<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserResponsable extends Model
{
    use HasFactory;

    public function getDateFormat()
    {
        return config('myconfig.date');
    }


    public function user()
    {
        return $this->belongsTo(user::class);
    }
}
