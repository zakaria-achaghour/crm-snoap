<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Network extends Model
{
    use HasFactory,SoftDeletes;
    public function getDateFormat()
    {
        return config('myconfig.date');
    }


    public function category(){
        return $this->belongsTo(Category::class);
    }

    // public function nugs()
    // {
    //     return $this->hasMany(NetworkUgRegionmc::class);
    // }

    public function regionmcs()
    {
        return $this->belongsToMany(Regionmc::class, 'regionmc_networks', 'regionmc_id', 'network_id')->withTimestamps();
        
    }

    public function advs()
    {
        return $this->hasMany(Adv::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'network_product', 'network_id', 'product_id');
    }

    public function plvs()
    {
      return $this->belongsToMany(Plv::class, 'plv_network', 'network_id', 'plv_id')->withTimestamps();

       
    }
}
