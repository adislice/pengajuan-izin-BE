<?php

namespace App\Authorization;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class IzinAuthorization {

    public static function initialize() 
    {
        Gate::define('list-izin', function (User $user) {
            return in_array($user->level, [0, 1, 2]);
        });
        Gate::define('show-izin', function (User $user) {
            return in_array($user->level, [0, 1, 2]);
        });
        Gate::define('create-izin', function (User $user) {
            return in_array($user->level, [2]);
        });
        Gate::define('update-izin', function (User $user) {
            return in_array($user->level, [2]);
        });
        Gate::define('accept-izin', function (User $user) {
            return in_array($user->level, [1]);
        });
        Gate::define('reject-izin', function (User $user) {
            return in_array($user->level, [1]);
        });
        Gate::define('revise-izin', function (User $user) {
            return in_array($user->level, [1]);
        });
        Gate::define('delete-izin', function (User $user) {
            return in_array($user->level, [0, 1, 2]);
        });
        Gate::define('cancel-izin', function (User $user) {
            return in_array($user->level, [2]);
        });
    }
}