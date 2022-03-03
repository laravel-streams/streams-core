<?php

namespace Streams\Core\Support\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Field\FieldDecorator;
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
 */
trait Fluency
{

    use Prototype;

    public function fill(array $attributes)
    {
        return $this->loadPrototypeAttributes($attributes);
    }

    public function decorate($key): FieldDecorator
    {
        //return $this->decoratePrototypeAttribute($key);

        $name = Str::camel('decorate_' . $key . '_attribute');

        $value = $this->getPrototypeAttribute($key);

        if ($this->hasPrototypeOverrideMethod($name)) {
            return $this->{Str::camel($name)}($value);
        }

        $type = $this->stream()->fields->get($key);

        $type->entry = $this;

        return $type->decorate($value);
    }

    public function setAttributes(array $attributes)
    {
        return $this->setPrototypeAttributes($attributes);
    }

    public function getAttributes()
    {
        $attributes = $this->getPrototypeAttributes();

        Arr::pull($attributes, 'stream');

        return $attributes;
    }

    public function hasAttribute($key)
    {
        return $this->hasPrototypeAttribute($key);
    }

    public function getAttribute($key)
    {
        return $this->getPrototypeAttribute($key);
    }

    public function getRawAttribute($key)
    {
        return $this->getPrototypeAttributeFromArray($key);
    }

    public function setAttribute($key, $value)
    {
        return $this->setPrototypeAttribute($key, $value);
    }

    public function toArray()
    {
        return Hydrator::dehydrate($this, [
            'stream',
        ]);
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
