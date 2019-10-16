<?php


namespace Shea\Component\Routing;

use Shea\Component\Http\Response;
use Shea\Contracts\Routing\ResponseFactory as FactoryContract;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseFactory implements FactoryContract
{
    public function make($content = '', $status = 200, array $headers = [])
    {
        return new Response($content, $status, $headers);
    }

    public function json($data = [], $status = 200, array $headers = [], $options = 0)
    {
        //todo  这里使用的是syfony组件
        return new JsonResponse($data, $status, $headers, $options);
    }

    public function jsonp($callback, $data = [], $status = 200, array $headers = [], $options = 0)
    {
        return $this->json($data, $status, $headers, $options)->setCallback($callback);
    }

    public function file($file, array $headers = [])
    {
        return new BinaryFileResponse($file, 200, $headers);
    }
}