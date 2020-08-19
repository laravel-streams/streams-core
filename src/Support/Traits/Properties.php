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

    /**
     * The attribute values.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The object properties.
     *
     * @var array
     */
    protected $properties = [];

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * Fill the attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Return the key expression value
     * from the attribuets array.
     * 
     * Or default.
     * 
     * @param mixed $key
     * @param null $default
     * @return mixed
     */
    public function attr($key, $default = null)
    {
        return Arr::get($this->attributes, $key, $default);
    }

    /**
     * Expand an attribute value.
     *
     * @param string $key
     * @return mixed
     */
    public function expand($key)
    {
        return $this->expandAttributeValue($key, $this->getAttributes()[$key] ?? $this->propertyDefault($key));
    }

    /**
     * Get an attribute.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        return $this->getAttributeValue($key);
        // if (
        //     $this->offsetExists($key) ||
        //     $this->hasAttributeGetter($key) ||
        //     $this->hasAttributeType($key)
        // ) {
        //     return $this->getAttributeValue($key);
        // }

        // return $this->propertyDefault($key);
    }

    /**
     * Return the attribute's value.
     *
     * @param string $key
     */
    public function getAttributeValue($key)
    {
        return $this->transformAttributeValue($key, $this->getAttributes()[$key] ?? $this->propertyDefault($key));
    }

    /**
     * Set the attribute's value.
     *
     * @param string $key
     */
    public function setPropertyAttributeValue($key, $value)
    {
        $this->attributes[$key] = $this->transformAttributeValue($key, $value);

        return $this;
    }

    /**
     * Return a properties default value.
     *
     * @param string $key
     */
    protected function propertyDefault($key)
    {
        return Arr::get($this->properties, $key . '.default');
    }

    /**
     * Transform the attribute value via mutators, types, etc.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    protected function transformAttributeValue($key, $value)
    {
        $name = 'get_' . $key . '_attribute';

        if ($this->hasAttributeOverrideMethod($name)) {
            return $this->{Str::camel('get_' . $key . '_attribute')}($value);
        }

        if ($this->hasAttributeType($key)) {
            return $this->restoreAttributeValue($key, $value);
        }

        return $value;
    }

    protected function expandAttributeValue($key, $value): Value
    {
        $name = 'expand_' . $key . '_attribute';

        if ($this->hasAttributeOverrideMethod($name)) {
            return $this->{Str::camel($name)}($value);
        }

        $type = $this->newAttributeFieldType($key);

        $type->field = $key;

        return $type->expand($value);
    }

    /**
     * Set an attribute value.
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        return $this->setPropertyAttributeValue($key, $value);
    }

    public function getAttributes(): array
    {
        return $this->attributes;
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

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    // ------------------------  LOCAL UTILITY  ---------------------------

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
}
