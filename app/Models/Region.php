<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    public function getDateFormat()
    {
        return config('myconfig.date');
    }

    use SoftDeletes;

    public function villes()
    {
        return $this->hasMany(Ville::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
