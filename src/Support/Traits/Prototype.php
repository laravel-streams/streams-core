<?php

namespace Streams\Core\Support\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Field\Field;
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
 *      $object->attribute = $value;
 * 
 * Attributes can be expanded:
 * 
 *      echo $object->expandPrototypeAttribute('attribute'); // A new Value instance
 */
trait Prototype
{

    use Macroable;
    use FiresCallbacks;

    /**
     * The prototype information.
     */
    protected $__prototype = [
        'attributes' => [],
        'properties' => [],
        'original' => [],
    ];

    public function __construct(array $attributes = [])
    {
        $this->loadPrototypeProperties($this->__properties ?? []);
        $this->loadPrototypeAttributes($this->__attributes ?? []);

        $this->initializePrototypeAttributes($attributes);
    }

    public function __get(string $key)
    {
        return $this->getPrototypeAttribute($key);
    }

    public function __set(string $key, $value): void
    {
        $this->setPrototypeAttribute($key, $value);
    }

    protected function initializePrototypeAttributes(array $attributes)
    {
        $this->__prototype['original'] = $attributes;

        return $this->loadPrototypeAttributes($attributes);
    }

    public function loadPrototypeAttributes(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->setPrototypeAttribute($key, $value);
        }

        return $this;
    }

    /**
     * Trim non-defined attributes.
     *
     * @return $this
     */
    public function strictPrototypeAttributes()
    {
        $allowed = $this->getPrototypeProperties();
        $attributes = $this->getPrototypeAttributes();

        $this->setPrototypeAttributes(array_intersect_key($attributes, $allowed));

        return $this;
    }

    public function setPrototypeAttributes(array $attributes)
    {
        $this->__prototype['attributes'] = [];

        foreach ($attributes as $key => $value) {
            $this->setPrototypeAttribute($key, $value);
        }

        return $this;
    }

    public function getPrototypeAttributes(): array
    {
        return $this->__prototype['attributes'];
    }

    public function getOriginalPrototypeAttributes(): array
    {
        return $this->__prototype['original'];
    }

    public function setPrototypeAttribute(string $key, $value)
    {
        $method = Str::camel('set_' . $key . '_attribute');

        if ($this->hasPrototypeOverrideMethod($method)) {

            $this->{$method}($value);

            return $this;
        }

        if ($this->hasPrototypePropertyType($key)) {

            $modified = $this->modifyPrototypeAttributeValue($key, $value);

            $this->__prototype['attributes'][$key] = $modified;

            return $this;
        }

        $this->setPrototypeAttributeValue($key, $value);

        return $this;
    }

    public function setPrototypeAttributeValue(string $key, $value)
    {
        Arr::set($this->__prototype['attributes'], $key, $value);

        return $this;
    }

    public function getPrototypeAttribute(string $key, $default = null)
    {
        $method = Str::camel('get_' . $key . '_attribute');

        if ($this->hasPrototypeOverrideMethod($method)) {
            return $this->{$method}();
        }

        return $this->getPrototypeAttributeValue($key, $default);
    }

    public function getPrototypeAttributeValue(string $key, $default = null)
    {
        if (array_key_exists($key, $this->__prototype['attributes'])) {
            $value = $this->__prototype['attributes'][$key];
        } else {
            $value = $this->getPrototypeAttributeDefault($key, $default);
        }

        // if ($this->hasPrototypePropertyType($key)) {
        //     return $this->restorePrototypeAttributeValue($key, $value);
        // }

        if (is_null($value)) {
            $value = $default;
        }

        return $value;
    }

    public function expandPrototypeAttribute(string $key): Value
    {
        $method = Str::camel('expand_' . $key . '_attribute');

        $value = $this->getPrototypeAttribute($key);

        if ($this->hasPrototypeOverrideMethod($method)) {
            return $this->{$method}($value);
        }

        $type = $this->newProtocolPropertyFieldType($key);

        // @todo this is not right.. tuck it away
        if ($this->stream) {
            $type->field = $this->stream->fields->get($key);
            $type->entry = $this;
        }

        return $type->expand($value);
    }

    public function getPrototypeAttributeDefault(string $key, $default = null)
    {
        return Arr::get($this->__prototype['properties'], $key . '.default', $default);
    }

    protected function guessProtocolPropertyType($key): string
    {
        $default = $this->getPrototypeAttributeDefault($key);

        $type = gettype($this->getPrototypeAttributeValue($key, $default));

        if ($type === 'NULL') {
            $type = 'string';
        }

        if ($type === 'double') {
            $type = 'decimal';
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

        if ($this->stream) {
            $type->field = $this->stream->fields->get($key);
        }

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

        if ($this->stream) {
            $type->field = $this->stream->fields->get($key);
        }

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

        $attributes = Arr::get($this->__prototype['properties'], $key, []);

        if ($this instanceof Field) {
            $attributes['field'] = $this;
        }

        return App::make('streams.core.field_type.' . $type)
            ->loadPrototypeAttributes($attributes);
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

        if (method_exists($this, $name)) {
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
