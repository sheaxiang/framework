<?php

namespace Shea\Bootstrap;

use Shea\Contracts\Foundation\Application;

class RegisterProviders
{
    public function bootstrap(Application $app)
    {
        $app->registerConfiguredProviders();
    }
}
