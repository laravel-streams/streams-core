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

    use Macroable {
        Macroable::__call as private callMacroable;
    }

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
        $this->initializePrototypeTrait($attributes);

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
     * Mapp methods to expanded values.
     *
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (static::hasMacro($method)) {
            return $this->callMacroable($method, $arguments);
        }

        $key = Str::snake($method);

        if ($this->hasPrototypeAttribute($key)) {
            return $this->expandPrototypeAttribute($key);
        }

        throw new \BadMethodCallException(sprintf(
            'Method %s::%s does not exist.', static::class, $method
        ));
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
    protected function initializePrototypeTrait(array $attributes)
    {
        $this->loadPrototypeProperties(Arr::pull($attributes, '__properties', []));

        $attributes = array_merge_recursive($this->getPrototypeAttributes(), $attributes);

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
        if ($this->hasPrototypeAttributeOverride($name = Str::camel('set_' . $key . '_attribute'))) {

            if (self::hasMacro($name)) {

                $this->{$name}($value);

                return $this;
            }

            $this->{$name}($value);

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
    public function getPrototypeAttribute($key, $default = null)
    {
        $parts = explode('.', $original = $key);

        $key = array_shift($parts);

        if ($this->hasPrototypeAttributeOverride($name = Str::camel('get_' . $key . '_attribute'))) {
            return $this->{$name}();
        }

        return $this->getPrototypeAttributeValue($original, $default);
    }
    
    /**
     * Get an attribute value.
     *
     * @param string $key
     * @return mixed|Value
     */
    public function getPrototypeAttributeValue($key, $default = null)
    {
        $parts = explode('.', $key);

        $key = array_shift($parts);

        $value = $this->__prototype['attributes'][$key] ?? $this->getPrototypePropertyDefault($key, $default);

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
        $name = Str::camel('expand_' . $key . '_attribute');

        $value = $this->getPrototypeAttribute($key);

        if ($this->hasPrototypeAttributeOverride($name)) {
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
     * @param mixed $default
     */
    protected function getPrototypePropertyDefault($key, $default = null)
    {
        return Arr::get($this->__prototype['properties'], $key . '.default', $default);
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
    protected function hasPrototypeAttributeOverride($name): bool
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
