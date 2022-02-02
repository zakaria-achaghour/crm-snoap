<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionmcNetwork extends Model
{
    use HasFactory;
    public function getDateFormat()
    {
        return config('myconfig.date');
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_regionmc_network', 'user_id', 'regionmc_network_id')->withTimestamps();
        
    }
}
