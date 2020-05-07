<?php

namespace Anomaly\Streams\Platform\Image\Concerns;

use Intervention\Image\Constraint;

/**
 * Trait HasAttributes
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasAttributes
{

    /**
     * The image attributes.
     *
     * @var array
     */
    public $attributes = [];

    /**
     * Return if a method is an attribute
     * method for Intervention.
     *
     * @param string $method
     *
     * @return bool
     */
    public function isAttribute(string $method)
    {
        return in_array($method, [
            'blur',
            'brightness',
            'colorize',
            'resizeCanvas',
            'contrast',
            'copy',
            'crop',
            'fit',
            'flip',
            'gamma',
            'greyscale',
            'heighten',
            'insert',
            'interlace',
            'invert',
            'limitColors',
            'pixelate',
            'opacity',
            'resize',
            'rotate',
            'amount',
            'widen',
            'orientate',
            'text',
        ]);
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
     * @param  array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Add an attribute.
     *
     * @param  $name
     * @param null|string $value
     * @return $this
     */
    public function addAttribute($name, $value = null)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Return if attribute is present.
     *
     * @param $method
     * @return bool
     */
    public function hasAttribute($name)
    {
        return array_key_exists($name, $this->attributes);
    }
}
