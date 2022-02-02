<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    public function getDateFormat()
    {
        return config('myconfig.date');
    }

    public function exercice(){
        return $this->belongsTo(Exercice::class);
    }

    public function resauxes()
    {
        return $this->hasMany(Resaux::class);
    }
}
