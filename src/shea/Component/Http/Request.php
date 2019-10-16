<?php

namespace Shea\Component\Http;

use Shea\Component\Http\Concerns\InteractsWithInput;
use Shea\Component\Support\Arr;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Request extends SymfonyRequest 
{
    use InteractsWithInput;
    
    public static function capture()
    {
        static::enableHttpMethodParameterOverride();
        
        //这里需返回本实例
        return static::createFromBase(SymfonyRequest::createFromGlobals());
    }

    /**
     * create Shea request form SymfonyRequest
     */
    public static function createFromBase(SymfonyRequest $request)
    {
        if ($request instanceof static) {
            return $request;
        }

        $content = $request->content;

        $request = (new static)->duplicate(
            $request->query->all(), $request->request->all(), $request->attributes->all(),
            $request->cookies->all(), $request->files->all(), $request->server->all()
        );

        $request->content = $content;

        $request->request = $request->getInputSource();

        return $request;
    }

    protected function getInputSource()
    {
        //todo 
        return in_array($this->getRealMethod(), ['GET', 'HEAD']) ? $this->query : $this->request;
    }

    public function duplicate(array $query = null, array $request = null, array $attributes = null, array $cookies = null, array $files = null, array $server = null)
    {
        return parent::duplicate($query, $request, $attributes, $cookies, $files, $server);//todo $files
    }

    public function instance()
    {
        return $this;
    }

    public function path()
    {
        $pattern = trim($this->getPathInfo(), '/');

        return $pattern == '' ? '/' : $pattern;
    }

    /**
     * 对已编码的url字符串进行编码
     * @return string
     */
    public function decodedPath()
    {
        return rawurldecode($this->path());
    }

    public function ajax()
    {
        return $this->isXmlHttpRequest();
    }

    public function pjax()
    {
        return $this->headers->get('X-PJAX') == true;
    }

    /**
     * 判断请求是否通过https
     * @return bool
     */
    public function secure()
    {
        return $this->isSecure();
    }

    /**
     * 获取ip
     * @return string|null
     */
    public function ip()
    {
        return $this->getClientIp();
    }

    public function ips()
    {
        return $this->getClientIps();
    }

    public function userAgent()
    {
        return $this->headers->get('User-Agent');
    }

    public function get($key, $default = null)
    {
        return parent::get($key, $default);
    }

    public function session()
    {
        if (!$this->hasSession()) {
            throw new RuntimeException('Session store not set on request.');
        }

        return $this->session;
    }

    public function getSession()
    {
        return $this->session;
    }

    public function __isset($key)
    {
        return ! is_null($this->__get($key));
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->all())) {
            return Arr::get($this->all(), $key);
        }

        //todo 获取路由参数

        return null;
    }
}