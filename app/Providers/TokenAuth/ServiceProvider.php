<?php

namespace App\Providers\TokenAuth;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    public function register()
    {
        $this->app->singleton('app.tokenAuth', function ($app) {
            return new Manager();
        });
    }

    public function provides()
    {
        return [
            'app.tokenAuth'
        ];
    }
}