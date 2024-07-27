<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // $this->registerPolicies();

        Gate::define('admin', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('author', function (User $user) {
            return $user->hasRole('author');
        });
    }
}
