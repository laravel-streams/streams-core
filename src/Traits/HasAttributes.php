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

    use HasMemory;

    /**
     * Get an attribute value.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (!array_key_exists($key, $this->attributes)) {
            throw new \Exception("Attribute [{$key}] does not exist on " . static::class);
        }

        return $this->attributes[$key];
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
     * Get the attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
