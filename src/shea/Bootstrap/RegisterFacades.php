<?php

namespace Shea\Bootstrap;

use Shea\AliasLoader;
use Shea\Component\Support\Facades\Facade;
use Shea\Contracts\Foundation\Application;

class RegisterFacades
{
    public function bootstrap(Application $app)
    {
        Facade::setFacadeApplication($app);
        
        AliasLoader::getInstance($app->make('config')->get('app.aliases', []))->register();
    }
}
