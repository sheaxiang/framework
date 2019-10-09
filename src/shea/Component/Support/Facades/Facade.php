<?php

namespace Shea\Component\Support\Facades;

use RuntimeException;

class Facade
{
    protected static $app;

    protected static $resolvedInstance;

    public static function setFacadeApplication($app)
    {
        static::$app = $app;
    }

    public static function getFacadeApplication()
    {
        return static::$app;
    }

    public static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacade());
    }

    protected static function resolveFacadeInstance($name)
    {
        if (is_object($name)) {
            return $name;
        }

        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }
        
        return static::$resolvedInstance[$name] = static::$app[$name];
    }

    protected static function getFacadeAccessor()
    {
        throw new RuntimeException('Facade does not implement getFacade method.');
    }

    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();

        if (! $instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }
}
