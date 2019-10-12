<?php

namespace Shea\Component\Providers;

abstract class ServiceProvider
{
    protected $app;
    
    public function __construct($app)
    {
        $this->app = $app;
    }
}
