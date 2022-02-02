<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ville extends Model
{
    public function getDateFormat()
    {
        return config('myconfig.date');
    }


    use SoftDeletes;

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
    public function region()
    {
        return $this->belongsTo(region::class);
    }
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
    public function fournisseurs()
    {
        return $this->hasMany(Fournisseur::class);
    }
}
