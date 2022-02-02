<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{    
    public function getDateFormat()
    {
        return config('myconfig.date');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function plvs()
    {
      return $this->belongsToMany(Plv::class, 'client_plv', 'client_id', 'plv_id')->withPivot('finished_at')->withTimestamps();
  
      
    }
}
