<?php

namespace Anomaly\Streams\Platform\Ui\Traits;

/**
 * Trait HasHtmlAttributes
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait HasHtmlAttributes
{

    /**
     * The links attributes.
     *
     * @var array
     */
    protected $attributes = [];

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
     * Check if an attribute exists.
     *
     * @param string $attribute
     * @return bool
     */
    public function hasAttribute($attribute)
    {
        return array_key_exists($attribute, $this->attributes);
    }

    /**
     * Get a single attribute.
     *
     * @param string $attribute
     * @param mixed $default
     * @return mixed
     */
    public function getAttribute($attribute, $default = null)
    {
        return array_get($this->attributes, $attribute, $default);
    }

    /**
     * Merge in new attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function mergeAttributes(array $attributes)
    {
        $this->attributes = $this->attributes($attributes);

        return $this;
    }

    /**
     * Add a new attribute.
     *
     * @param string $attribute
     * @param mixed $value
     * @return $this
     */
    public function addAttribute(string $attribute, $value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }

        $this->attributes[$attribute] = $value;

        return $this;
    }

    /**
     * Return merged attributes.
     *
     * @param array $attributes
     * @return array
     */
    public function attributes(array $attributes = [])
    {
        return array_filter(array_merge($this->attributes, $attributes));
    }
}
