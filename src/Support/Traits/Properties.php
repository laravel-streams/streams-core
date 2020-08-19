<?php

namespace Anomaly\Streams\Platform\Support\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Field\Value\Value;

/**
 * Trait Properties
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
trait Properties
{

    use Macroable;


    protected $attributes = [];

    protected $properties = [];


    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    public function attr($key, $default = null)
    {
        return Arr::get($this->attributes, $key, $default);
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function expand($key): Value
    {
        $name = 'expand_' . $key . '_attribute';

        $value = $this->getAttribute($key);

        if ($this->hasAttributeOverrideMethod($name)) {
            return $this->{Str::camel($name)}($value);
        }

        $type = $this->newAttributeFieldType($key);

        $type->field = $key;

        return $type->expand($value);
    }

    public function getAttribute($key)
    {
        $name = 'get_' . $key . '_attribute';

        if ($this->hasAttributeOverrideMethod($name)) {
            return $this->{Str::camel($name)}();
        }

        $value = $this->attributes[$key] ?? $this->propertyDefault($key);

        if ($this->hasAttributeType($key)) {
            return $this->restoreAttributeValue($key, $value);
        }

        return $value;
    }

    public function setAttribute($key, $value)
    {
        $name = 'set_' . $key . '_attribute';

        if ($this->hasAttributeOverrideMethod($name)) {
            
            $this->{Str::camel($name)}($value);

            return $this;
        }

        if ($this->hasAttributeType($key)) {
            
            $this->attributes[$key] = $this->modifyAttributeValue($key, $value);

            return $this;
        }

        $this->attributes[$key] = $value;

        return $this;
    }

    protected function propertyDefault($key)
    {
        return Arr::get($this->properties, $key . '.default');
    }

    protected function guessPropertyType($key): string
    {
        $type = gettype(Arr::get($this->attributes, $key));

        if ($type === 'NULL') {
            $type = 'string';
        }

        if ($type === 'object') {
            $type = null;
        }

        if ($type === 'double') {
            $type = 'float';
        }

        return $type;
    }

    protected function hasAttributeOverrideMethod($name): bool
    {
        if (self::hasMacro($name)) {
            return true;
        }

        if (method_exists($this, Str::camel($name))) {
            return true;
        }

        return false;
    }

    protected function restoreAttributeValue($key, $value)
    {
        $type = $this->newAttributeFieldType($key);

        $type->field = $key;

        return $type->restore($value);
    }

    protected function modifyAttributeValue($key, $value)
    {
        $type = $this->newAttributeFieldType($key);

        $type->field = $key;

        return $type->modify($value);
    }

    protected function newAttributeFieldType($key)
    {
        if (!$type = Arr::get($this->properties, $key . '.type')) {
            $type = $this->guessPropertyType($key);
        }

        return App::make('streams.field_types.' . $type, Arr::get($this->properties, $key, []));
    }

    public function hasAttributeType($key)
    {
        return isset($this->properties) ? (bool) Arr::get($this->properties, $key . '.type') : false;
    }



    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->attributes);
    }

    public function offsetGet($offset)
    {
        return $this->attributes[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        if (null === $offset) {
            $this->attributes[] = $value;
        } else {
            $this->attributes[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->attributes[$offset]);
    }
}
