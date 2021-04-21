<?php

namespace Streams\Core\Support\Traits;

use Illuminate\Support\Str;
use Streams\Core\Support\Facades\Hydrator;

/**
 * Trait Fluency
 * 
 * By default you can load Property classes
 * by passing an array of attributes:
 * 
 *      $object = new Class(array $attributes)
 * 
 * Attributes support a basic public property API
 * 
 *      echo $object->attribute; // attribute value
 * 
 * Attributes can be expanded:
 * 
 *      echo $object->expand('attribute'); // A new Value instance
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait Fluency
{

    use Prototype;

    public function fill(array $attributes)
    {
        return $this->loadPrototypeAttributes($attributes);
    }

    public function expand($key)
    {
        return $this->expandPrototypeAttribute($key);
    }

    public function setAttributes(array $attributes)
    {
        return $this->setPrototypeAttributes($attributes);
    }

    public function getAttributes()
    {
        return $this->getPrototypeAttributes();
    }

    public function getAttribute($key)
    {
        return $this->getPrototypeAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        return $this->setPrototypeAttribute($key, $value);
    }

    public function toArray()
    {
        return Hydrator::dehydrate($this);
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
