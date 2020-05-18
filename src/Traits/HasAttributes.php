<?php

namespace Anomaly\Streams\Platform\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Entry\Entry;

/**
 * Trait HasAttributes
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait HasAttributes
{

    use Hookable;

    /**
     * The types array.
     *
     * @var array
     */
    protected $attributeTypes = [];

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->buildAttributeTypes($this->attributes);

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
            $this->hasAttributeMutator($key) ||
            $this->hasAttributeType($key)
        ) {
            return $this->getAttributeValue($key);
        }

        //return $this->getRelationValue($key);
        return $this->attr($key);
    }

    /**
     * Return the attribute's value.
     *
     * @param string $key
     */
    public function getAttributeValue($key)
    {
        return $this->transformAttributeValue($key, $this->getAttributes()[$key] ?? null);
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
        if ($this->hasAttributeMutator($key)) {
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
     * Build the attribute type definitions.
     *
     * @param array $attributes
     */
    protected function buildAttributeTypes(array $attributes = [])
    {
        foreach ($attributes as $attribute) {

            if (!is_array($attribute)) {

                if ($attribute === null) {
                    $attribute = [
                        'type' => $attribute,
                    ];
                }
            }
        }

        $this->attributeTypes = $attributes;
    }

    /**
     * Return if the object has an attribute mutator.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function hasAttributeMutator($key)
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
        $type = $this->attributeTypes[$key];

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

                return (bool) $value;

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
        return $this->attributeTypes ? array_key_exists($key, $this->attributeTypes) : false;
    }
}
