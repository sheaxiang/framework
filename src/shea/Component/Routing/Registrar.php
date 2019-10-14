<?php

namespace Shea\Component\Routing;

interface Registrar
{
    /**
     * Register a new GET route with the router.
     *
     * @param  string  $uri
     * @param  \Closure|array|string  $action
     * @return \Illuminate\Routing\Route
     */
    public function get($uri, $action);

    /**
     * Register a new POST route with the router.
     *
     * @param  string  $uri
     * @param  \Closure|array|string  $action
     * @return \Illuminate\Routing\Route
     */
    public function post($uri, $action);

    /**
     * Register a new PUT route with the router.
     *
     * @param  string  $uri
     * @param  \Closure|array|string  $action
     * @return \Illuminate\Routing\Route
     */
    public function put($uri, $action);

    /**
     * Register a new DELETE route with the router.
     *
     * @param  string  $uri
     * @param  \Closure|array|string  $action
     * @return \Illuminate\Routing\Route
     */
    public function delete($uri, $action);

    /**
     * Register a new PATCH route with the router.
     *
     * @param  string  $uri
     * @param  \Closure|array|string  $action
     * @return \Illuminate\Routing\Route
     */
    public function patch($uri, $action);

    /**
     * Register a new OPTIONS route with the router.
     *
     * @param  string  $uri
     * @param  \Closure|array|string  $action
     * @return \Illuminate\Routing\Route
     */
    public function options($uri, $action);
}
