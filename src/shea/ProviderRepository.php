<?php

namespace Shea;

use Shea\Contracts\Foundation\Application;

class ProviderRepository 
{
    protected $app;
    
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function load(array $providers)
    {
        foreach ($providers as $provider) {
            $this->app->register($provider);
        }
    }
}