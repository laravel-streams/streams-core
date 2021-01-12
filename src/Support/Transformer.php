<?php

namespace Streams\Core\Support;

use ReflectionProperty;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Support\Traits\Prototype;

class Transformer
{

    /**
     * Transform an object.
     *
     * @param $object
     * @param array $parameters
     * @return mixed
     */
    public function transform($object, array $parameters = [])
    {
        dd($object);
    }
}
