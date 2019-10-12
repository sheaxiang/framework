<?php

namespace Shea\Component\Database;

use Shea\Component\Providers\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($this->app['config']->get('database'));
        $capsule->bootEloquent();
        $capsule->setAsGlobal();

        $this->app->singleton('db', 'Illuminate\Database\Capsule\Manager');
    }
}