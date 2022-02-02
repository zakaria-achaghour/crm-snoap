<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // create users
        // $admin = User::create([
        //     'username' => 'a.admin',
        //     'email' => 'admin@admin.com',
        //     'firstname' => 'admin',
        //     'lastname' => 'admin',
        //     'gender' => 'male',
        //     'contact' => '06 000000000',
        //     'password' => Hash::make('password'),
            
        // ]);
    

    //    $role =  Role::create(['name' => 'admin']);
    //    $role2 =  Role::create(['name' => 'Responsable-Animateur']);

    //    $role3 =  Role::create(['name' => 'Animateur']);


    //         // attach role and user
    //         $admin->roles()->attach($role);

    // DB::table('months')->insert([[

    
    //     'Mois' => 'Janvier'
    // ],[
    //     'Mois' => 'Février'
    // ],[
    //     'Mois' => 'Mars'
    // ],[
    //     'Mois' => 'Avril'
    // ],[
    //     'Mois' => 'Mai'
    // ],[
    //     'Mois' => 'Juin'
    // ],[
    //     'Mois' => 'Juillet'
    // ],[
    //     'Mois' => 'Aout'
    // ],[
    //     'Mois' => 'Septembre'
    // ],[
    //     'Mois' => 'Octobre'
    // ],[
    //     'Mois' => 'Novembre'
    // ],[
    //     'Mois' => 'Décembre'
    // ]]);
    }
}
