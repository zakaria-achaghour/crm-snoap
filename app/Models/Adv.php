<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adv extends Model
{
    use HasFactory,SoftDeletes;
    public function getDateFormat()
    {
        return config('myconfig.date');
    }


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function network() {
        return $this->belongsTo(Network::class);
    }
    public function regionmc() {
        return $this->belongsTo(Regionmc::class);
    }
    
    public function ug() {
        return $this->belongsTo(Ug::class);
    }
    
    public function doctor() {
        return $this->belongsTo(Doctor::class);
    }
    
    public function nature() {
        return $this->belongsTo(Nature::class);
    }
      
    public function month() {
        return $this->belongsTo(Month::class);
    }
    
    public function products(){
        return $this->belongsToMany(Product::class, 'adv_product', 'adv_id', 'product_id')->withPivot('qte')->withTimestamps();
    }

}
