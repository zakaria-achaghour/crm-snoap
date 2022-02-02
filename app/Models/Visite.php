<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visite extends Model
{
    use HasFactory;
    public function getDateFormat()
    {
        return config('myconfig.date');
    }


    public function doctor(){
        return $this->belongsToMany(Doctor::class, 'visite_doctor_enquet', 'visite_id', 'doctor_id')->withTimestamps();
    }
    public function productsDoctors(){
        return $this->belongsToMany(Product::class, 'visite_product_doctor', 'visite_id', 'product_id')->withPivot('id','qte','miseEnPlace')->withTimestamps();
    }
    public function products(){
        return $this->belongsToMany(Product::class, 'visite_product', 'visite_id', 'product_id')->withPivot('qte','miseEnPlace')->withTimestamps();
    }
    public function commande()
    {
        return $this->hasOne(Commande::class);
    }

    public function duos(){
        return $this->belongsToMany(User::class, 'visite_duo', 'visite_id', 'user_id')->withPivot('responsable_id','note')->withTimestamps();
    }
}
