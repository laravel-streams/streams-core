<?php

namespace Streams\Core\Support\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Facades\App;
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
 *      echo $object->decoratePrototypeAttribute('attribute'); // A new Value instance
 */
trait Prototype
{

    use Macroable;
    use FiresCallbacks;

    protected \ReflectionClass $__reflection;

    protected array $__prototype = [
        'attributes' => [],
        'properties' => [],
        'original' => [],
    ];

    public function __construct(array $attributes = [])
    {
        // $this->bootIfNotBooted();
        // $this->initializeTraits();

        // $this->fill($attributes);

        // $this->syncOriginal();
        if ($this->__attributes) {
            $attributes = array_replace_recursive($this->__attributes, $attributes);
        }

        $this->syncPrototypePropertyAttributes();
        $this->syncOriginalPrototypeAttributes($attributes);

        $this->setPrototypeAttributes($attributes);

        if (isset($this->__properties)) {
            $this->loadPrototypeProperties($this->__properties);
        }
    }

    public function __get($key)
    {
        return $this->getPrototypeAttribute($key);
    }

    public function __set($key, $value)
    {
        $this->setPrototypeAttribute($key, $value);
    }

    public function syncOriginalPrototypeAttributes(array $attributes)
    {
        foreach ($this->getPrototypeProperties() as $key => $property) {

            if (property_exists($this, $key)) {
                $attributes[$key] = $this->{$key};
            }
        }
        
        $this->__prototype['original'] = $attributes;
    }

    public function syncPrototypePropertyAttributes()
    {
        $reflection = new \ReflectionClass($this);

        $test = $reflection->getProperties(\ReflectionProperty::IS_STATIC);

        $properties = array_diff(
            $reflection->getProperties(\ReflectionProperty::IS_PUBLIC),
            $reflection->getProperties(\ReflectionProperty::IS_STATIC)
        );

        foreach ($properties as $property) {

            $attribute = Arr::get($property->getAttributes(Field::class), 0);

            if (!$attribute && $parent = $reflection->getParentClass()) {
                $attribute = $this->resolvePrototypePropertyAttributes($parent, $property->getName());
            }

            if (!$attribute) {

                $type = $this->guessProtocolPropertyType($property->getName());

                $this->__prototype['properties'][$property->getName()] = [
                    'type' => $type,
                ];

                continue;
            }

            $attributes = Arr::get($attribute->getArguments(), 0, []);

            if (!isset($attributes['type']) && $type = $property->getType()) {
                $attributes['type'] = $type->getName();
            }

            $this->__prototype['properties'][$property->getName()] = $attributes;
        }
    }

    protected function resolvePrototypePropertyAttributes(\ReflectionClass $reflection, $key)
    {
        if (!$reflection->hasProperty($key)) {
            return null;
        }

        $property = $reflection->getProperty($key);

        return Arr::get($property->getAttributes(Field::class), 0);
    }

    public function loadPrototypeAttributes(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->setPrototypeAttribute($key, $value);
        }

        return $this;
    }

    public function setPrototypeAttributes(array $attributes)
    {
        $this->__prototype['attributes'] = [];

        // @todo reset properties?

        foreach ($attributes as $key => $value) {
            $this->setPrototypeAttribute($key, $value);
        }

        return $this;
    }

    public function trimUndefinedPrototypeAttributes()
    {
        $allowed = $this->getPrototypeProperties();
        $attributes = $this->getPrototypeAttributes();
        
        $this->setRawPrototypeAttributes(array_intersect_key($attributes, $allowed));

        return $this;
    }

    public function setRawPrototypeAttributes(array $attributes)
    {
        $this->__prototype['attributes'] = [];

        foreach ($attributes as $key => $value) {
            $this->setPrototypeAttributeValue($key, $value);
        }

        return $this;
    }

    public function getPrototypeAttributes(): array
    {
        $properties = [];

        foreach (array_keys($this->__prototype['properties']) as $field) {
            if (isset($this->{$field})) {
                $properties[$field] = $this->{$field}; 
            }
        }

        return $this->__prototype['attributes'] + $properties;
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
            $value = $this->castPrototypeAttributeValue($key, $value);
        }

        $this->setPrototypeAttributeValue($key, $value);

        return $this;
    }

    public function setPrototypeAttributeValue(string $key, $value)
    {
        if (property_exists($this, $key)) {
            $this->{$key} = $value;
        } else {
            Arr::set($this->__prototype['attributes'], $key, $value);
        }

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
        if ($this->hasPrototypeAttribute($key)) {
            $value = $this->getPrototypeAttributeFromData($key);
        } else {
            $value = $this->getPrototypeAttributeDefault($key, $default);
        }

        if (is_null($value) && is_null($value = $default)) {
            return $value;
        }

        if ($this->hasPrototypePropertyType($key)) {
            return $this->restorePrototypeAttributeValue($key, $value);
        }

        return $value;
    }

    public function getPrototypeAttributeFromData(string $key)
    {
        if (property_exists($this, $key)) {
            return $this->{$key};
        }

        return Arr::get($this->__prototype['attributes'], $key);
    }

    public function decoratePrototypeAttribute(string $key)
    {
        $method = Str::camel('decorate_' . $key . '_attribute');

        $value = $this->getPrototypeAttribute($key);

        if ($this->hasPrototypeOverrideMethod($method)) {
            return $this->{$method}($value);
        }

        $type = $this->newProtocolPropertyFieldType($key);

        $type->entry = $this;

        return $type->decorate($value);
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
            $type = 'number';
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

        if (isset($this->stream) && $this->stream instanceof Stream) {
            $type->field = $this->stream->fields->get($key);
        }

        if (is_null($value)) {
            return $value;
        }

        return $type->cast($type->restore($value));
    }

    /**
     * Modify a value for attributes.
     *
     * @param string $key
     * @param mixed $value
     */
    protected function castPrototypeAttributeValue($key, $value)
    {
        $type = $this->newProtocolPropertyFieldType($key);

        if (isset($this->stream) && $this->stream instanceof Stream) {
            $type->field = $this->stream->fields->get($key);
        }

        if (is_null($value)) {
            return $value;
        }

        return $type->cast($value);
    }

    protected function newProtocolPropertyFieldType(string $key): Field
    {
        if (!$type = Arr::get($this->__prototype['properties'], $key . '.type')) {
            $type = $this->guessProtocolPropertyType($key);
        }

        $attributes = Arr::get($this->__prototype['properties'], $key, []);

        if (isset($this->stream)) {
            $attributes['stream'] = $this->stream;
        }

        return App::make('streams.core.field_type.' . $type, compact('attributes'));
    }

    protected function hasPrototypePropertyType(string $key): bool
    {
        return (bool) $this->getPrototypePropertyType($key);
    }

    protected function getPrototypePropertyType(string $key): ?string
    {
        return Arr::get($this->__prototype['properties'], $key . '.type');
    }

    public function loadPrototypeProperties(array $properties)
    {
        foreach ($properties as $key => $value) {
            $this->setPrototypeProperty($key, $value);
        }

        return $this;
    }

    public function setPrototypeProperties(array $properties)
    {
        $this->__prototype['properties'] = [];

        foreach ($properties as $key => $value) {
            $this->setPrototypeProperty($key, $value);
        }

        return $this;
    }

    public function getPrototypeProperties(): array
    {
        return $this->__prototype['properties'];
    }

    public function setPrototypeProperty(string $key, $value)
    {
        $this->__prototype['properties'][$key] = $value;

        return $this;
    }

    public function getPrototypeProperty(string $key): array
    {
        return $this->__prototype['properties'][$key] ?? [];
    }

    protected function hasPrototypeOverrideMethod(string $name): bool
    {
        if (self::hasMacro($name)) {
            return true;
        }

        if (method_exists($this, $name)) {
            return true;
        }

        return false;
    }

    public function hasPrototypeAttribute(string $key): bool
    {
        if (array_key_exists($key, $this->__prototype['attributes'])) {
            return true;
        }

        if (property_exists($this, $key)) {
            return true;
        }

        return false;
    }

    public function __isset($name)
    {
        return $this->hasPrototypeAttribute($name);
    }
}
