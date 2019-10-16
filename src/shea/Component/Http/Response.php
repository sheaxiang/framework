<?php

namespace Shea\Component\Http;

use ArrayObject;
use JsonSerializable;
use Shea\Contracts\Support\Arrayable;
use Shea\Contracts\Support\Jsonable;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

class Response extends BaseResponse
{
    public function setContent($content)
    {
        //返回的内容
        $this->original = $content;

        //判断如果内容是Jsonable,则会转换为json
        if ($this->shouldBeJson($content)) {
            $this->header('Content-Type', 'application/json');

            $content = $this->morphToJson($content);
        }

        parent::setContent($content);

        return $this;
    }

    protected function shouldBeJson($content)
    {
        return $content instanceof Arrayable ||
            $content instanceof Jsonable ||
            $content instanceof ArrayObject ||
            $content instanceof JsonSerializable ||
            is_array($content);
    }

    protected function morphToJson($content)
    {
        if ($content instanceof Jsonable) {
            return $content->toJson();
        } elseif ($content instanceof Arrayable) {
            return json_encode($content->toArray());
        }

        return json_encode($content);
    }
}