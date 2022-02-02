<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ug extends Model
{
    use HasFactory,SoftDeletes;
    public function getDateFormat()
    {
        return config('myconfig.date');
    }


// public function nugs()
//     {
//         return $this->hasMany(NetworkUgRegionmc::class);
//     }

        public function regionmc()
        {
              return $this->belongsTo(Regionmc::class, 'regionmc_id');

           // return $this->belongsTo(Regionmc::class);
        }
        public function numugs()
        {
              return $this->belongsToMany(Numug::class,'ug_numug', 'num_ug','ug_id');
              
        }

        public function advs()
        {
            return $this->hasMany(Adv::class);
        }
//    public function doctors()
//     {
//         return $this->hasMany(Doctor::class);
//     }

        public function users()
            {
                return $this->belongsToMany(User::class);
                
            
            }
}
