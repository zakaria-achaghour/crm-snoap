<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    public function getDateFormat()
    {
        return config('myconfig.date');
    }


    public function visite()
    {
        return $this->belongsTo(Visite::class);
    }
}
