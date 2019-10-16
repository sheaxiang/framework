<?php

namespace Shea\Component\Routing;

use Shea\Component\Providers\ServiceProvider;
use Shea\Contracts\Routing\ResponseFactory as ResponseFactoryContract;

class RoutingServiceProvider extends ServiceProvider
{
    public function register()
    {
        //实例化路由
        $this->registerRouter();

        //绑定response, 面向接口实现
        $this->registerResponseFactory();
    }

    protected function registerRouter()
    {
        $this->app->instance('router',  new Router($this->app));
    }

    protected function registerResponseFactory()
    {
        $this->app->singleton(ResponseFactoryContract::class, function ($app) {
            return new ResponseFactory();
        });
    }
}