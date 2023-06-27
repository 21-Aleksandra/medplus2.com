<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('is_admin', function($user) {
            return $user->role==2;
        });

        Gate::define('is_user', function($user) {
            return $user->role==0;
        });

        Gate::define('is_manager', function($user) {
            return $user->role==1;
        });

        Gate::define('is_banned', function($user) {
            return $user->role==3;
        });
    }
}
