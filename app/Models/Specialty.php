<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialty extends Model
{
    use HasFactory, SoftDeletes;
    public function getDateFormat()
    {
        return config('myconfig.date');
    }


    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

}
