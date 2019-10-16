<?php


namespace Shea\Component\Routing;

use LogicException;
use Shea\Component\Support\Arr;

class RouteAction
{
    public static function parse($uri, $action)
    {
        //如果action为空,则uses指向闭包
        if (is_null($action)) {
            return static::missingAction($uri);
        }

        //判断是否为合法的可调用结构
        if (is_callable($action)) {
            return ! is_array($action) ? ['uses' => $action] : [
                'uses' => $action[0].'@'.$action[1],
                'controller' => $action[0].'@'.$action[1],
            ];
        } elseif (! isset($action['uses'])) {
            $action['uses'] = static::findCallable($action);
        }

        //todo

        return $action;
    }

    protected static function findCallable(array $action)
    {
        return Arr::first($action, function ($value, $key) {
            return is_callable($value) && is_numeric($key);
        });
    }

    protected static function missingAction($uri)
    {
        return ['uses' => function () use ($uri) {
            throw new LogicException("Route for [{$uri}] has no action.");
        }];
    }
}