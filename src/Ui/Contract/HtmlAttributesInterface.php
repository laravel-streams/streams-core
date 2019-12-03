<?php

namespace Anomaly\Streams\Platform\Ui\Contract;

/**
 * Interface HtmlAttributesInterface
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
interface HtmlAttributesInterface
{

    /**
     * Get the attributes.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Set the attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes);

    /**
     * Check if an attribute exists.
     *
     * @param string $attribute
     * @return bool
     */
    public function hasAttribute($attribute);

    /**
     * Get a single attribute.
     *
     * @param string $attribute
     * @param mixed $default
     * @return mixed
     */
    public function getAttribute($attribute, $default = null);

    /**
     * Merge in new attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function mergeAttributes(array $attributes);

    /**
     * Add a new attribute.
     *
     * @param string $attribute
     * @param mixed $value
     * @return $this
     */
    public function addAttribute(string $attribute, $value);

    /**
     * Return merged attributes.
     *
     * @param array $attributes
     */
    public function attributes(array $attributes = []);
}
