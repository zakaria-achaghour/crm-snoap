<?php


namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository
 
{

    public function delegues(){
      return   DB::table('users')->join('role_user','role_user.user_id','users.id')
                                          ->join('roles','roles.id','role_user.role_id')
                                            ->select('users.*')
                                            ->whereIn('name', ['Delegue','Responsable-Delegue','Manager+','Manager'])
                                            ->whereNull('users.deleted_at')
                                            ->get();
    }
    public function deleguesByUser($id) {
       return  DB::table('users')
        ->join('user_responsables', 'user_responsables.user_id', 'users.id')
        ->select('users.*')
        ->where('user_responsables.responsable_id', $id)
        ->whereNull('users.deleted_at')
        ->get();

    }

}

