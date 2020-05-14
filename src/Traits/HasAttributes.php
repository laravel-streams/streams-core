<?php

namespace Anomaly\Streams\Platform\Traits;

/**
 * Trait HasAttributes
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait HasAttributes
{

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = array_merge($this->attributes, $attributes);
    }

    /**
     * Fill the attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);

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
     * Get an attribute value.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        return $this->attr($key);
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
}
