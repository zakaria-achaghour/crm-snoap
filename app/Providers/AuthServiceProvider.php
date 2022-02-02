<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin.manage',function($user){
            return $user->hasRole('admin');
        });

         Gate::define('admin.administration',function($user){
            return $user->hasAnyRoles(['admin','administration']);
        });
        Gate::define('admin.administration.client.ecriture',function($user){
            return $user->hasAnyRoles(['admin','administration','client-ecriture']);
        });

        Gate::define('client.ecriture',function($user){
            return $user->hasRole('client-ecriture');
        });
        Gate::define('client.lecture',function($user){
            return $user->hasRole('client-lecture');
        });

        
        Gate::define('admin.Manager+.Manager.Responsable.Delegue',function($user){
            return $user->hasAnyRoles(['admin','Manager','Manager+','Responsable-Delegue','Delegue']);
        });

        Gate::define('admin.Manager',function($user){
            return $user->hasAnyRoles(['admin','Manager']);
        });

        Gate::define('admin.Manager+',function($user){
            return $user->hasAnyRoles(['admin','Manager+']);
        });

        Gate::define('admin.Manager+.Manager',function($user){
            return $user->hasAnyRoles(['admin','Manager+','Manager']);
        });
        Gate::define('admin.Manager+.Manager.Acheteur',function($user){
            return $user->hasAnyRoles(['admin','Manager+','Manager','Acheteur']);
        });


        Gate::define('admin.Acheteur',function($user){
            return $user->hasAnyRoles(['admin','Acheteur']);
        });

        Gate::define('admin.Manager.Responsable',function($user){
            return $user->hasAnyRoles(['admin','Manager','Responsable-Delegue','Manger+']);
        });
        

        Gate::define('Delegue.Responsable-Delegue.Acheteur',function($user){
            return $user->hasAnyRoles(['Delegue','Responsable-Delegue','Acheteur']);
        });

        Gate::define('Manager.Manager+.Delegue.Responsable-Delegue.Acheteur',function($user){
            return $user->hasAnyRoles(['Delegue','Responsable-Delegue','Acheteur','Manager+','Manager']);
        });
        
        Gate::define('delegue',function($user){
            return $user->hasRole('Delegue');
        });
       
    }
}
