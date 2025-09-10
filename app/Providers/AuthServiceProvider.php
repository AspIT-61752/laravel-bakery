<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

// class AuthServiceProvider extends AServiceProvider
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // https://laravel.com/docs/5.8/authorization#writing-gates
        // https://stackoverflow.com/questions/50203489/this-registerpolicies-method-in-appserviceprovider-not-found-for-passport-in-l
        // They point to the old docs, but I'm using 12.x, so I tried to find the equivalent in 12.x

        // 12.x docs: https://laravel.com/docs/12.x/authorization#writing-gates

        // It looks like registerPolicies is not needed if you are not using policies, I'm not sure what the difference is
        Gate::define('admin', function (User $user) {
            return $user->is_admin;
        });
    }
}
