<?php

namespace Streams\Core\Field\Decorator;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Streams\Core\Field\FieldDecorator;

class ArrayDecorator extends FieldDecorator
{
    public function collect(): Collection
    {
        return collect($this->value);
    }

    public function htmlAttributes($extra = []): string
    {
        $attributes = array_merge($this->value, $extra);

        array_walk($attributes, function (&$value, $key) {
            $value = $key . '="' . $value . '"';
        });

        return implode(' ', $attributes);
    }

    public function __call($method, $parameters)
    {
        if (is_object($this->value)) {
            return call_user_func_array([$this->value, $method], $parameters);
        }

        if (method_exists(Arr::class, $method)) {
            return Arr::{$method}($this->value, ...$parameters);
        }

        throw new \Exception("Method [{$method}] does not exist on [{self::class}].");
    }
}
