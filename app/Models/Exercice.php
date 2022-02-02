<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercice extends Model
{
    use HasFactory;
    public function getDateFormat()
    {
        return config('myconfig.date');
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function regionmcs()
    {
        return $this->hasMany(Regionmc::class);
    }
  
}
