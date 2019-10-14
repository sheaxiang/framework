<?php

namespace Shea\Component\Filesystem;

use Shea\Contracts\Filesystem\FileNotFoundException;

class Filesystem
{
    public function exists($path)
    {
        return file_exists($path);
    }

    public function requireOnce($file)
    {
        require_once $file;
    }

    public function require($file)
    {
        require $file;
    }

    public function getRequire($path)
    {
        if ($this->isFile($path)) {
            return $this->require($path);
        }

        throw new FileNotFoundException("File does not exist at path {$path}");
    }

    public function isFile($file)
    {
        return is_file($file);    
    }

    public function hash($path)
    {
        return md5_file($path);
    }
}