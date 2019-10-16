<?php


namespace Shea\Contracts\Routing;


interface ResponseFactory
{
    public function json($data = [], $status = 200, array $headers = [], $options = 0);
}