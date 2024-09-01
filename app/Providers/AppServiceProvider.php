<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('create-verifikator', function (User $user) {
            return in_array($user->level, [0]);
        });
        Gate::define('promote-user', function (User $user) {
            return in_array($user->level, [0]);
        });
        Gate::define('read-user', function (User $user) {
            return in_array($user->level, [0, 1, 2]);
        });
    }
}
