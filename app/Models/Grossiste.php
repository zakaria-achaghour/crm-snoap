<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grossiste extends Model
{
    use HasFactory, SoftDeletes;
    public function getDateFormat()
    {
        return config('myconfig.date');
    }


    public function ville(){
        return $this->belongsTo(Ville::class);
    }
}
