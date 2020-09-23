<?php

namespace Anomaly\Streams\Platform\Support\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Field\Value\Value;

/**
 * Trait Prototype
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
trait Prototype
{

    use Macroable;

    /**
     * The prototype information.
     */
    protected $__prototype = [
        'attributes' => [],
        'properties' => [],
        'original' => [],
    ];

    public function attr($key, $default = null)
    {
        return Arr::get($this->attributes, $key, $default);
    }

    /**
     * Create a new Prototype instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setPrototypeAttributes($attributes);

        $this->__prototype['original'] = $this->__prototype['attributes'];
    }

    /**
     * Map attribute access to attribute data.
     *
     * @param string $key
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Map attribute access to attribute data.
     *
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    /**
     * Set the prototype properties
     *
     * @param array $attributes
     * @return $this
     */
    public function setPrototypeAttributes(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * Set an attribute value.
     *
     * @param string $key
     * @param mixed $value
     */
    public function setAttribute($key, $value)
    {
        if ($this->hasPrototypeOverrideMethod($name = 'set_' . $key . '_attribute')) {

            $this->{Str::camel($name)}($value);

            return $this;
        }

        if ($this->hasPrototypePropertyFieldType($key)) {

            $this->__prototype['attributes'][$key] = $this->modifyAttributeValue($key, $value);

            return $this;
        }

        $this->__prototype['attributes'][$key] = $value;

        return $this;
    }

    /**
     * Get an attribute value.
     *
     * @param string $key
     * @return mixed|Value
     */
    public function getAttribute($key)
    {
        $parts = explode('.', $key);

        $key = array_shift($parts);

        if ($this->hasPrototypeOverrideMethod($name = 'get_' . $key . '_attribute')) {
            return $this->{Str::camel($name)}();
        }

        $value = $this->__prototype['attributes'][$key] ?? $this->defaultProtocolProperty($key);

        if ($this->hasPrototypePropertyFieldType($key)) {
            return $this->restoreAttributeValue($key, $value);
        }

        if ($parts) {
            dd($parts);
            return data_get($value, implode('.', $parts));
        }

        return $value;
    }

    /**
     * Get the prototype attributes.
     *
     * @return array
     */
    public function getPrototypeAttributes(): array
    {
        return $this->__prototype['attributes'];
    }

    /**
     * Expand a field value.
     *
     * @param string $key
     * @return Value
     */
    public function expand($key)
    {
        $name = 'expand_' . $key . '_attribute';

        $value = $this->getAttribute($key);

        if ($this->hasPrototypeOverrideMethod($name)) {
            return $this->{Str::camel($name)}($value);
        }

        $type = $this->newProtocolPropertyFieldType($key);

        $type->field = $key;
        $type->entry = $this;

        return $type->expand($value);
    }

    /**
     * Return the default property
     *
     * @param string $key
     */
    protected function defaultProtocolProperty($key)
    {
        return Arr::get($this->__prototype['properties'], $key . '.default');
    }

    /**
     * Guess the protocol property type.
     *
     * @param string $key
     * @return string
     */
    protected function guessProtocolPropertyType($key): string
    {
        $default = Arr::get($this->__prototype['properties'], $key . '.default');

        $type = gettype(Arr::get($this->__prototype['attributes'], $key, $default));

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

    /**
     * Restore a value from attributes.
     *
     * @param string $key
     * @param mixed $value
     */
    protected function restoreAttributeValue($key, $value)
    {
        $type = $this->newProtocolPropertyFieldType($key);

        $type->field = $key;

        return $type->restore($value);
    }

    /**
     * Modify a value for attributes.
     *
     * @param string $key
     * @param mixed $value
     */
    protected function modifyAttributeValue($key, $value)
    {
        $type = $this->newProtocolPropertyFieldType($key);

        $type->field = $key;

        return $type->modify($value);
    }

    /**
     * Return a new property field type.
     *
     * @param string $key
     * @return FieldType
     */
    protected function newProtocolPropertyFieldType($key)
    {
        if (!$type = Arr::get($this->__prototype['properties'], $key . '.type')) {
            $type = $this->guessProtocolPropertyType($key);
        }

        return App::make('streams.field_types.' . $type)->setPrototypeAttributes(Arr::get($this->__prototype['properties'], $key, []));
    }

    /**
     * Check if the given attribute key
     * has a specified property type.
     *
     * @param [type] $key
     *
     * @return bool
     */
    protected function hasPrototypePropertyFieldType($key)
    {
        return (bool) Arr::get($this->__prototype['properties'], $key . '.type');
    }

    /**
     * Check if there is an override method
     * specified on this prototype object.
     * 
     *
     * @param string $name
     *
     * @return bool
     */
    protected function hasPrototypeOverrideMethod($name): bool
    {
        if (self::hasMacro($name)) {
            return true;
        }

        if (method_exists($this, Str::camel($name))) {
            return true;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Arrayable Methods
    |--------------------------------------------------------------------------
    */

    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->__prototype['attributes']);
    }

    public function offsetGet($offset)
    {
        return $this->__prototype['attributes'][$offset];
    }

    public function offsetSet($offset, $value): void
    {
        if (null === $offset) {
            $this->__prototype['attributes'][] = $value;
        } else {
            $this->__prototype['attributes'][$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->__prototype['attributes'][$offset]);
    }
}
