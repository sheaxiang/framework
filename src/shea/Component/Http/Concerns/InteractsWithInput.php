<?php

namespace Shea\Component\Http\Concerns;

use Shea\Component\Support\Arr;

trait InteractsWithInput
{
    public function all($keys = null)
    {
        //todo files
        $input = $this->input();

        if (!$keys) {
            return $input;
        }

        $results = [];

        //不是数组就获取传入方法的参数值
        foreach (is_array($keys) ? $keys : func_get_args() as $key) {
            Arr::set($result, $key, Arr::get($input, $key));
        }

        return $results;
    }

    public function input($key = null, $default = null)
    {
        return Arr::get($this->getInputSource()->all() + $this->query->all(),$key = null, $default = null);
    }
}