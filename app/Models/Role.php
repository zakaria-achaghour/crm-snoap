<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
  use HasFactory, SoftDeletes;

  public function getDateFormat()
  {
    return config('myconfig.date');
  }




  public function users()
  {
    return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');

    //return $this->belongsToMany(User::class)->withTimestamps();
  }
  // public function services()
  // {
  //     return $this->belongsToMany(Service::class, 'role_user', 'service_id', 'role_id')->withTimestamps();
  // }
 
}
