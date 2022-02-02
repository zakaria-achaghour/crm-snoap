<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisiteDoctor extends Model
{
    use HasFactory;
    public function getDateFormat()
    {
        return config('myconfig.date');
    }


    public function duos(){
        return $this->belongsToMany(User::class, 'visite_doctor_duo', 'visite_doctor_id', 'user_id')->withPivot('responsable_id','note')->withTimestamps();
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'visite_doctor_product', 'visite_doctor_id', 'product_id')->withPivot('qte','miseEnPlace')->withTimestamps();
    }
}
