<?php

namespace Streams\Core\Support\Traits;

use Streams\Core\Support\Facades\Hydrator;

/**
 * Trait Eloquence
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
trait Eloquence
{

    use Prototype;

    public function fill(array $attributes)
    {
        return $this->setPrototypeAttributes($attributes);
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
