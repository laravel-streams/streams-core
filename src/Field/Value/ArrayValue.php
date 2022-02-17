<?php

namespace Streams\Core\Field\Value;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ArrayValue extends Value
{

    /**
     * Return a collection of the value.
     * 
     * @return Collection
     */
    public function collect()
    {
        return collect($this->value);
    }

    /**
     * Return the array value as an html attributes string.
     *
     * @param array $attributes
     *
     * @return string
     */
    public function htmlAttributes($attributes = []): string
    {
        $attributes = array_merge($this->value, $attributes);

        array_walk($attributes, function (&$value, $key) {
            $value = $key . '="' . $value . '"';
        });

        return implode(' ', $attributes);
    }

    /**
     * Map calls through the array helper.
     *
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (method_exists(Arr::class, $method)) {
            return Arr::{$method}($this->value, ...$arguments);
        }

        throw new \Exception("Method [{$method}] does not exist on [{self::class}].");
    }
}
