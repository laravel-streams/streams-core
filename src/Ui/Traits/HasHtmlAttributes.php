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
     * The HTML attributes.
     *
     * @var array
     */
    protected $htmlAttributes = [];

    /**
     * Get the attributes.
     *
     * @return array
     */
    public function getHtmlAttributes()
    {
        return $this->htmlAttributes;
    }

    /**
     * Set the HTML attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function setHtmlAttributes(array $attributes)
    {
        $this->htmlAttributes = $attributes;

        return $this;
    }

    /**
     * Check if an HTML attribute exists.
     *
     * @param string $attribute
     * @return bool
     */
    public function hasHtmlAttribute($attribute)
    {
        return array_key_exists($attribute, $this->htmlAttributes);
    }

    /**
     * Get a single attribute.
     *
     * @param string $attribute
     * @param mixed $default
     * @return mixed
     */
    public function getHtmlAttribute($attribute, $default = null)
    {
        return array_get($this->htmlAttributes, $attribute, $default);
    }

    /**
     * Merge in new attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function mergeHtmlAttributes(array $attributes)
    {
        $this->attributes = $this->htmlAttributes($attributes);

        return $this;
    }

    /**
     * Add a new HTML attribute.
     *
     * @param string $attribute
     * @param mixed $value
     * @return $this
     */
    public function addHtmlAttribute(string $attribute, $value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }

        $this->attributes[$attribute] = $value;

        return $this;
    }

    /**
     * Return merged HTML attributes.
     *
     * @param array $attributes
     * @return array
     */
    public function attributes(array $attributes = [])
    {
        return array_merge($this->attributes, $attributes);
    }

    /**
     * Merge HTML attribute defaults on.
     *
     * @param array $defaults
     * @param array $attributes
     */
    final static function mergeAttributeDefaults(array $defaults, array &$attributes)
    {
        foreach ($defaults as $key => $default) {
            $attributes[$key] = array_get($attributes, $key, $default);
        }
    }
}
