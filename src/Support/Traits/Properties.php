<?php

namespace Anomaly\Streams\Platform\Support\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Traits\Hookable;

/**
 * Trait Properties
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait Properties
{

    use Hookable;

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
        $this->buildProperties();

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
        return data($this->attributes, $key, $default);
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
        return array_get($this->properties, $key . '.default');
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
            return $this->mutateAttributeValue($key, $value);
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
     * Get the properties.
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
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

    public function offsetExists($offset)
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

    /**
     * Build property definitions.
     *
     * @return void
     */
    protected function buildProperties()
    {

        /**
         * If we don't have any attributes
         * then we have nothing to do at all.
         * 
         * Can't guess and don't need anything!
         */
        if (!isset($this->attributes)) {
            return;
        }

        /**
         * If we have properties defined
         * then we can skip this step.
         */
        if (!empty($this->properties)) {
            return;
        }

        /**
         * Build the properties from
         * default attribute values.
         */
        $this->properties = array_map(function ($attribute) {

            /**
             * Type sniff the attribute value.
             */
            // $type = gettype($attribute);

            // /**
            //  * Default type is string.
            //  */
            // if ($type === 'NULL') {
            //     $type = 'string';
            // }

            // /**
            //  * "double" is returned in lieue
            //  * of float for historical reasons.
            //  */
            // if ($type === 'double') {
            //     $type = 'float';
            // }

            /**
             * Default property definition.
             */
            $attribute = [
                //'type' => $type,
                'default' => $attribute,
            ];

            return $attribute;
        }, $this->attributes);

        $this->attributes['__initialized'] = true;
    }

    /**
     * Return if the object has an attribute getter.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function hasAttributeGetter($key)
    {
        if ($this->hasHook('get_', $key . '_attribute')) {
            return true;
        }

        if (method_exists($this, Str::studly('get_' . $key . '_attribute'))) {
            return true;
        }

        return false;
    }

    /**
     * Return if the object has an attribute setter.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function hasAttributeSetter($key)
    {
        if ($this->hasHook('set_', $key . '_attribute')) {
            return true;
        }

        if (method_exists($this, Str::studly('get_' . $key . '_attribute'))) {
            return true;
        }

        return false;
    }

    /**
     * Run the attribute mutator
     * and return the value.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return mixed|null
     */
    public function mutateAttributeValue($key, $value)
    {
        if ($this->hasHook($hook = 'get_', $key . '_attribute')) {
            return $this->call($hook, compact('value'));
        }

        if (method_exists($this, $method = Str::studly('get_' . $key . '_attribute'))) {
            return $this->{$method}($value);
        }

        return $value;
    }

    /**
     * Run the attribute type
     * cast and return the value.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    protected function typeCastAttributeValue($key, $value)
    {
        $type = $this->properties[$key]['type'];

        switch ($type) {

            case 'int':
            case 'integer':

                return (int) $value;

            case 'real':
            case 'float':
            case 'double':

                switch ((string) $value) {
                    case 'Infinity':
                        return INF;
                    case '-Infinity':
                        return -INF;
                    case 'NaN':
                        return NAN;
                    default:
                        return (float) $value;
                }

            case 'decimal':
                return number_format($value, explode(':', $this->getCasts()[$key], 2)[1]);

            case 'string':

                return (string) $value;

            case 'bool':
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOL);

            case 'object':
                return json_decode($value);

            case 'array':
            case 'json':
                return json_decode($value, true);

            case 'collection':

                return new Collection($this->json_decode($value, true));

                // case 'date':

                //     return $this->asDate($value);

                // case 'datetime':
                // case 'custom_datetime':

                //     return $this->asDateTime($value);

                // case 'timestamp':

                //     return $this->asTimestamp($value);
        }

        return $value;
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
        return isset($this->properties) ? array_get($this->properties, $key . '.type') : false;
    }
}
