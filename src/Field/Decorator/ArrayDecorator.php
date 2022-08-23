<?php

namespace Streams\Core\Field\Decorator;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Streams\Core\Field\FieldDecorator;

class ArrayDecorator extends FieldDecorator
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

    /**
     * Map calls through the array helper.
     *
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __get($attribute)
    {
        if (is_object($this->value)) {
            return $this->value->$attribute;
        }

        return Arr::get($this->value, $attribute);
    }
}
