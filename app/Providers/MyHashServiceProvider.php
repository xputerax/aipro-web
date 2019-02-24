<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Tools\MyHashManager;

class MyHashServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('hash', function ($app) {
            return new MyHashManager($app);
        });

        $this->app->singleton('hash.driver', function ($app) {
            return $app['hash']->driver();
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
