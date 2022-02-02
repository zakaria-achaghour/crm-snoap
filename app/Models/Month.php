<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    use HasFactory;
    public function getDateFormat()
    {
        return config('myconfig.date');
    }

    public function advs() {
        return $this->belongsTo(Adv::class);
    }
}
