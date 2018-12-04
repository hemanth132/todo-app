<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Services\BasicAuthGuard;
use App\Providers\BasicAuthProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\ToDoList' => 'App\Policies\ToDoListPolicy',
        'App\Task' => 'App\Policies\TaskPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // add custom guard provider
        Auth::provider('basic_auth_provider', function ($app, array $config) {
          return new BasicAuthProvider();
        });

        // add custom guard
        Auth::extend('auth_header', function ($app, $name, array $config) {
          return new BasicAuthGuard(Auth::createUserProvider($config['provider']), $app->make('request'));
        });
    }
}
