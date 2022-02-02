<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plv extends Model
{
    use HasFactory,SoftDeletes;
    public function getDateFormat()
    {
        return config('myconfig.date');
    }



    public function clients()
    {
      return $this->belongsToMany(Client::class, 'client_plv', 'client_id', 'plv_id')->withPivot('finished_at')->withTimestamps();
  
      
    }

    public function doctors()
    {
      return $this->belongsToMany(Doctor::class, 'doctor_plv', 'doctor_id', 'plv_id')->withPivot('finished_at')->withTimestamps();
  
      
    }

    public function networks()
    {
      return $this->belongsToMany(Network::class, 'plv_network', 'network_id', 'plv_id')->withTimestamps();
       
    }
}
