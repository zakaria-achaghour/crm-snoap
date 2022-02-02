<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Numug extends Model
{
    use HasFactory;

    protected $fillable = [
        'id'
    ];
    public function getDateFormat()
    {
        return config('myconfig.date');
    }

    public  function ugs(){
        return $this->belongsToMany(Ug::class,'ug_numug', 'num_ug','ug_id');

    }
}
