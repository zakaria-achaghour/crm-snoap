<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regionmc extends Model
{
    use HasFactory,SoftDeletes;
    public function getDateFormat()
    {
        return config('myconfig.date');
    }



   public function networks()
   {
       return $this->belongsToMany(Network::class, 'regionmc_networks', 'regionmc_id', 'network_id')->withTimestamps();
       
   }

public function exercice(){
    return $this->belongsTo(Exercice::class);
}

// public function nugs()
//     {
//         return $this->hasMany(NetworkUgRegionmc::class);
//     }
    public function ugs()
    {
        return $this->hasMany(Ug::class);
    }
    
    public function advs()
    {
        return $this->hasMany(Adv::class);
    }
}
