<?php

namespace App\Providers;

use App\Models\User;

use App\Policies\PostPolicy;
use App\Policies\CommentPolicy;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Post::class => PostPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function ($user) {
            return $user->hasRole('admin');
        });


        Gate::define('author', function (User $user) {
            return $user->hasRole('author');
        });
    }
}
