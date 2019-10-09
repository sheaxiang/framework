<?php

namespace Shea;

class AliasLoader
{

    protected $aliases;

    private function __construct($aliases)
    {
        $this->aliases = $aliases;
    }

    public static function getInstance(array $aliases = [])
    {
        return new static($aliases);
    }

   //todo
   public function load($alias)
   {
       if (isset($this->aliases[$alias])) {
           return class_alias($this->aliases[$alias], $alias);
       }
   }

   public function register()
   {
       $this->prependToLoaderStack();
   }

   protected function prependToLoaderStack()
   {
       spl_autoload_register([$this, 'load'], true, true);
   }
}
