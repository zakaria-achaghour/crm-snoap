<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    public function getDateFormat()
    {
        return config('myconfig.date');
    }

    //
}
