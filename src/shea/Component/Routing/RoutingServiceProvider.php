<?php

namespace Shea\Component\Routing;

use Shea\Component\Providers\ServiceProvider;

class RoutingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerRouter();
    }

    protected function registerRouter()
    {
        $this->app->instance('router',  new Router($this->app));
    }
}