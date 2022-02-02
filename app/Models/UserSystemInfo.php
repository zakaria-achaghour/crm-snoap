<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSystemInfo extends Model
{
    use HasFactory;

    public function getDateFormat()
    {
        return config('myconfig.date');
    }
}
