<?php

namespace Streams\Core\Support\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Streams\Core\Field\Value\Value;
use Illuminate\Support\Traits\Macroable;

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

    /**
     * Create a new Prototype instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->initializePrototype($attributes);

        $this->__prototype['original'] = $this->__prototype['attributes'];
    }

    /**
     * Map attribute access to attribute data.
     *
     * @param string $key
     */
    public function __get($key)
    {
        return $this->getPrototypeAttribute($key);
    }

    /**
     * Map attribute access to attribute data.
     *
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        $this->setPrototypeAttribute($key, $value);
    }

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        $attributes = array_merge($this->getPrototypeAttributes(), $attributes);

        return $this->setPrototypeAttributes($attributes);
    }

    /**
     * Load prototype attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function loadPrototypeAttributes(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->setPrototypeAttribute($key, $value);
        }

        return $this;
    }

    /**
     * Set the prototype properties
     *
     * @param array $attributes
     * @return $this
     */
    public function setPrototypeAttributes(array $attributes)
    {
        $this->__prototype['attributes'] = [];

        foreach ($attributes as $key => $value) {
            $this->setPrototypeAttribute($key, $value);
        }

        return $this;
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
     * Get the original prototype attributes.
     *
     * @return array
     */
    public function getOriginalPrototypeAttributes(): array
    {
        return $this->__prototype['original'];
    }

    /**
     * Set an attribute value.
     *
     * @param string $key
     * @param mixed $value
     */
    public function setPrototypeAttribute($key, $value)
    {
        if ($this->hasPrototypeOverrideMethod($name = 'set_' . $key . '_attribute')) {

            $this->{Str::camel($name)}($value);

            return $this;
        }

        if ($this->hasPrototypePropertyType($key)) {

            $this->__prototype['attributes'][$key] = $this->modifyPrototypeAttributeValue($key, $value);

            return $this;
        }

        $this->setPrototypeAttributeValue($key, $value);

        return $this;
    }

    /**
     * Set the value on the prototype's attributes.
     *
     * @param string $key
     * @param mixed $value
     */
    public function setPrototypeAttributeValue($key, $value)
    {
        Arr::set($this->__prototype['attributes'], $key, $value);

        return $this;
    }

    /**
     * Get an attribute value.
     *
     * @param string $key
     * @return mixed|Value
     */
    public function getPrototypeAttribute($key)
    {
        $parts = explode('.', $key);

        $key = array_shift($parts);

        if ($this->hasPrototypeOverrideMethod($name = 'get_' . $key . '_attribute')) {
            return $this->{Str::camel($name)}();
        }

        $value = $this->__prototype['attributes'][$key] ?? $this->getPrototypePropertyDefault($key);

        if ($this->hasPrototypePropertyType($key)) {
            return $this->restorePrototypeAttributeValue($key, $value);
        }
        
        if ($parts) {
            return data_get($value, implode('.', $parts));
        }

        return $value;
    }

    /**
     * Expand a field value.
     *
     * @param string $key
     * @return Value
     */
    public function expandPrototypeAttribute($key)
    {
        $name = 'expand_' . $key . '_attribute';

        $value = $this->getPrototypeAttribute($key);

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
    protected function getPrototypePropertyDefault($key)
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
    protected function restorePrototypeAttributeValue($key, $value)
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
    protected function modifyPrototypeAttributeValue($key, $value)
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
    protected function hasPrototypePropertyType($key)
    {
        return (bool) Arr::get($this->__prototype['properties'], $key . '.type');
    }

    /**
     * Load prototype properties.
     *
     * @param array $properties
     * @return $this
     */
    public function loadPrototypeProperties(array $properties)
    {
        foreach ($properties as $key => $value) {
            $this->setPrototypeProperty($key, $value);
        }

        return $this;
    }

    /**
     * Set the prototype properties
     *
     * @param array $properties
     * @return $this
     */
    public function setPrototypeProperties(array $properties)
    {
        $this->__prototype['properties'] = [];

        foreach ($properties as $key => $value) {
            $this->setPrototypeProperty($key, $value);
        }

        return $this;
    }

    /**
     * Get the prototype properties.
     *
     * @return array
     */
    public function getPrototypeProperties(): array
    {
        return $this->__prototype['properties'];
    }

    /**
     * Set an attribute value.
     *
     * @param string $key
     * @param mixed $value
     */
    public function setPrototypeProperty($key, $value)
    {
        $this->__prototype['properties'][$key] = $value;

        return $this;
    }

    /**
     * Get an attribute value.
     *
     * @param string $key
     * @return mixed|Value
     */
    public function getPrototypeProperty($key)
    {
        $parts = explode('.', $key);

        $key = array_shift($parts);

        $value = $this->__prototype['properties'][$key] ?? [];

        if ($parts) {
            return data_get($value, implode('.', $parts));
        }

        return $value;
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

    /**
     * Check if an attribute exists.
     * 
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasPrototypeAttribute($key): bool
    {
        if (isset($this->__prototype['attributes'][$key])) {
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
