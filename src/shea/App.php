<?php

namespace Shea;

use Shea\Contracts\Foundation\Application as ApplicationContract;

class App extends Container implements ApplicationContract
{
    const VERSION = '1.2.0'; 

    protected $basePath;

    protected $storagePath;

    /**
     * App实例
     */
    public static $app;

    protected $environmentPath;

    //辅助程序是否已加载
    protected $hasBeenBootstrapped = false;

    protected $environmentFile = '.env';

    /**
     * 注册的系统服务
     * @var array
     */
    protected $services = [];

    protected $initialize = false;

    public function __construct($basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }
        
        $this->registerBaseBindings();
        $this->basicsInstance();
    }

    protected function registerBaseBindings()
    {
       //将基本绑定注册到容器中
       static::setInstance($this);

       //todo
       $this->instance(App::class, $this);
       $this->instance(Container::class, $this);
    }

    public function registerConfiguredProviders()
    {
        (new ProviderRepository($this))->load($this->config['app.providers']);
    }

    public function register($service, $force = false)
    {
        $registered = $this->getService($service);

        if ($registered && !$force) {
            return $registered;
        }

        //如果是字符,将new
        if (is_string($service)) {
            $service = new $service($this);
        }

        if (method_exists($service, 'register')) {
            $service->register();
        }

        if (method_exists($service, 'boot')) {
            $service->boot();
        }

        //检测是否有这个属性
        if (property_exists($service, 'bind')) {
            $this->bind($service->bind);
        }

        $this->services[] = $service;

        return $service;
    }

    /**
     * 获取服务
     */
    public function getService($service)
    {
        $name = is_string($service) ? $service : get_class($service);
        return array_values(array_filter($this->services, function ($value) use ($name) {
            return $value instanceof $name;
        }, ARRAY_FILTER_USE_BOTH))[0] ?? null;
    }

    public function setBasePath($basePath)
    {
        //删除字符
        $this->basePath = rtrim($basePath, '\/');

        $this->bindPathsInContainer();

        return $this;
    }

    protected function bindPathsInContainer()
    {
        $this->instance('path.app', $this->appPath());
        $this->instance('path.base', $this->basePath());
        $this->instance('path.config', $this->configPath());
        $this->instance('path.router', $this->routerPath());
        $this->instance('path.public', $this->publicPath());
        $this->instance('path.storage', $this->storagePath());
    }

    public function bootstrapWith(array $bootstrappers)
    {
        $this->hasBeenBootstrapped = true;
    
        foreach ($bootstrappers as $bootstrapper) {
            $this->make($bootstrapper)->bootstrap($this);
        }
    }

    public function basicsInstance()
    {
        foreach ([
            'app' => \Shea\App::class,
            'router' => \Shea\Component\Routing\Router::class
        ] as $key => $instance) {
            $this->singleton($key, $instance);
        }
    }

    public function hasBeenBootstrapped()
    {
        return $this->hasBeenBootstrapped;
    }

    public function appPath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'app'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function basePath($path = '')
    {
        return $this->basePath.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function configPath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'config'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    public function routerPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'router';
    }

    public function publicPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'public';
    }

    public function storagePath()
    {
        return $this->storagePath ?: $this->basePath.DIRECTORY_SEPARATOR.'storage';
    }

    public function environmentPath()
    {
        return $this->environmentPath ?: $this->basePath;
    }

    public function environmentFile()
    {
        return $this->environmentFile ?: '.env';
    }

    public function version()
    {
        return static::VERSION;    
    }
}