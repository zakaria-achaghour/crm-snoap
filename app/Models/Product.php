<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public function getDateFormat()
    {
        return config('myconfig.date');
    }


   
    public const Products_Types = [
        'Médicament' => 'Médicament',
        'Complément Alimentaire' => 'Complément Alimentaire',
        'Dispositif Médicaux' => 'Dispositif Médicaux',

    ];



    public function dci(){
        return $this->belongsTo(Dci::class);
    }

    // visites pharmacy
    public function visites(){
        return $this->belongsToMany(Visite::class, 'visite_product', 'visite_id', 'product_id')->withPivot('qte','miseEnPlace')->withTimestamps();
    }

    public function advs(){
        return $this->belongsToMany(Adv::class, 'adv_product', 'adv_id', 'product_id')->withPivot('qte')->withTimestamps();
    }
    // visites doctors
    public function visitesDoctors(){
        return $this->belongsToMany(VisiteDoctor::class, 'visite_doctor_product', 'visite_doctor_id', 'product_id')->withPivot('qte','miseEnPlace')->withTimestamps();
    }

    // enquet pharmacy 
    public function visitesDoctor(){
        return $this->belongsToMany(Visite::class, 'visite_product_doctor', 'visite_id', 'product_id')->withPivot('qte','miseEnPlace')->withTimestamps();
    }

    public function networks(){
        return $this->belongsToMany(Network::class, 'network_product', 'network_id', 'product_id');
    }
}
