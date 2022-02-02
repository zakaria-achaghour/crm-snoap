<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classe extends Model
{
    use HasFactory , SoftDeletes;
    public function getDateFormat()
    {
        return config('myconfig.date');
    }


    // public function products(){
    //     return $this->hasMany(Product::class);


        
    // }
    public function dcis()
    {
        return $this->hasMany(Dci::class);
    }
}
