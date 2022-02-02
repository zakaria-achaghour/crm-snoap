<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    public function getDateFormat()
    {
        return config('myconfig.date');
    }

    public const LOCALES = [
        'en' => 'English',
        'fr' => 'French'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'firstname', 'lastname', 'gender', 'contact', 'email', 'password', 'status', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userResponsables()
    {
        return $this->hasMany(UserResponsable::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
        //return $this->belongsToMany(Role::class)->withTimestamps()->withPivot('service_id');
    }
    public function ugs()
    {
        return $this->belongsToMany(Ug::class);
    }

    // public function nugs()
    // {
    //     return $this->belongsToMany(NetworkUgRegionmc::class, 'user_nug', 'user_id', 'network_ug_regionmc_id')->withTimestamps();

    // }
    public function limites()
    {
        return $this->hasMany(Limite::class);
    }

    public function rns()
    {
        return $this->belongsToMany(RegionmcNetwork::class, 'user_regionmc_network', 'user_id', 'regionmc_network_id')->withTimestamps();
    }

    public function visites()
    {
        return $this->belongsToMany(Visite::class, 'visite_duo', 'visite_id', 'user_id')->withPivot('responsable_id', 'note')->withTimestamps();
    }

    public function objectifs()
    {
        return $this->hasMany(Objectif::class);
    }
    public function advs()
    {
        return $this->hasMany(Adv::class);
    }

    public function visitesDoctors()
    {
        return $this->belongsToMany(VisiteDoctor::class, 'visite_doctor_duo', 'visite_doctor_id', 'user_id')->withPivot('responsable_id', 'note')->withTimestamps();
    }
    // methods to check user has roles
    public function hasAnyRoles($roles)
    {
        if ($this->roles()->whereIn('name', $roles)->first()) {
            return true;
        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    public  function chek_user($user)
    {

        if (Auth::user() != $user) {
            return false;
        } else {
            return true;
        }
    }


    public function isOnline()
    {

        return Cache::has('user-is-online-' . $this->id);
    }
}
