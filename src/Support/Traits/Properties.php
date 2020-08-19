<?php

namespace Anomaly\Streams\Platform\Support\Traits;

use Carbon\Carbon;
use DateTimeInterface;
use Carbon\CarbonInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Field\FieldType;
use Anomaly\Streams\Platform\Field\Value\Value;

/**
 * Trait Properties
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
        if (
            $this->offsetExists($key) ||
            $this->hasAttributeGetter($key) ||
            $this->hasAttributeType($key)
        ) {
            return $this->getAttributeValue($key);
        }

        return $this->attr($key, $this->propertyDefault($key));
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
    public function setAttributeValue($key, $value)
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
        /**
         * Mutators may step in
         * and handle transforming.
         */
        if ($this->hasAttributeGetter($key)) {
            return $this->{Str::camel('get_' . $key . '_attribute')}($value);
        }

        /**
         * If the attribute is defined by a type
         * then let the type class cast the value.
         */
        if ($this->hasAttributeType($key)) {
            return $this->typeCastAttributeValue($key, $value);
        }

        return $value;
    }

    protected function expandAttributeValue($key, $value): Value
    {
        if ($this->hasAttributeExpander($key)) {
            return $this->{Str::camel('expand_' . $key . '_attribute')}($value);
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
        if (
            $this->offsetExists($key) ||
            $this->hasAttributeSetter($key) ||
            $this->hasAttributeType($key)
        ) {
            return $this->setAttributeValue($key, $value);
        }

        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Get the attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Dynamically retrieve attributes.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes.
     *
     * @param string  $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    // ------------------------  ARRAY ACCESS  ---------------------------

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

    protected function hasAttributeGetter($key): bool
    {
        return $this->hasAttributeOverrideMethod('get_' . $key . '_attribute');
    }

    protected function hasAttributeSetter($key): bool
    {
        return $this->hasAttributeOverrideMethod('set_' . $key . '_attribute');
    }

    protected function hasAttributeExpander($key): bool
    {
        return $this->hasAttributeOverrideMethod('expand_' . $key . '_attribute');
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

    protected function typeCastAttributeValue($key, $value)
    {
        $type = $this->newAttributeFieldType($key);

        $type->field = $key;

        return $type->restore($value);
    }

    protected function newAttributeFieldType($key)
    {
        if (!$type = Arr::get($this->properties, $key . '.type')) {
            $type = $this->guessPropertyType($key);
        }

        return App::make('streams.field_types.' . $type, Arr::get($this->properties, $key, []));
    }

    /**
     * Return if the object has an attribute type.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasAttributeType($key)
    {
        return isset($this->properties) ? (bool) Arr::get($this->properties, $key . '.type') : false;
    }
}
