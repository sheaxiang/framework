<?php

namespace Shea\Component\Providers;

/**
 * @mixin \Illuminate\Routing\Router
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * The controller namespace for the application.
     *
     * @var string|null
     */
    protected $namespace;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutes();
    }

    protected function loadRoutes()
    {
        if (method_exists($this, 'map')) {
            $this->map();
        }
    }
}
