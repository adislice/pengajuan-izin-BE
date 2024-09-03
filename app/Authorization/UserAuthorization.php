<?php

namespace App\Authorization;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserAuthorization {

    public static function initialize()
    {
        Gate::define('create-verifikator', function (User $user) {
            return in_array($user->level, [0]);
        });
        Gate::define('promote-user', function (User $user) {
            return in_array($user->level, [0]);
        });
        Gate::define('list-user', function (User $user) {
            return in_array($user->level, [0, 1]);
        });
        Gate::define('verify-user', function (User $user) {
            return in_array($user->level, [1]);
        });
        Gate::define('show-user', function (User $user) {
            return in_array($user->level, [0, 1, 2]);
        });
    }
}