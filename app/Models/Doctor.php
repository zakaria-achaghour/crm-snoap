<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;
    public function getDateFormat()
    {
        return config('myconfig.date');
    }


    public function specialty(){
        return $this->belongsTo(Specialty::class);
    }

    public function ville(){
        return $this->belongsTo(Ville::class);
    }

    public function ug(){
        return $this->belongsTo(Ug::class);
    }

    public function region(){
        return $this->belongsTo(Region::class);
    }

    public function visites(){
        return $this->belongsToMany(Visite::class, 'visite_doctor_visite', 'visite_id', 'doctor_id')->withTimestamps();
    }

    public function plvs()
    {
      return $this->belongsToMany(Plv::class, 'doctor_plv', 'doctor_id', 'plv_id')->withPivot('finished_at')->withTimestamps();
  
      
    }
    public function advs()
    {
        return $this->hasMany(Adv::class);
    }
}
