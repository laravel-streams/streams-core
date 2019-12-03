<?php

namespace Anomaly\Streams\Platform\Ui\Icon;

use Anomaly\Streams\Platform\Ui\Traits\HasClassAttribute;
use Anomaly\Streams\Platform\Ui\Traits\HasHtmlAttributes;

/**
 * Class Icon
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Icon
{

    use HasClassAttribute;
    use HasHtmlAttributes;

    /**
     * The icon type.
     *
     * @var string
     */
    protected $type;

    /**
     * Get the type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type.
     *
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Return the icon output.
     *
     * @return string
     */
    public function output()
    {
        return '<i ' . html_attributes($this->attributes()) . '></i>';
    }

    /**
     * Return class HTML.
     *
     * @param string $class
     * @return null|string
     */
    public function class($class = null)
    {
        return trim(implode(' ', [
            $class,
            $this->getType(),
            $this->getClass()
        ]));
    }

    /**
     * Return merged attributes.
     *
     * @param array $attributes
     */
    public function attributes(array $attributes = [])
    {
        return array_merge($this->attributes, [
            'class' => $this->class()
        ], $attributes);
    }

    /**
     * Return the icon output.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->output();
    }
}
