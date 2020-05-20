<?php

namespace Anomaly\Streams\Platform\Ui\Icon;

use Anomaly\Streams\Platform\Support\Traits\Properties;

/**
 * Class Icon
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Icon
{

    use Properties;

    /**
     * The button attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type' => null,
        'attributes' => [],
    ];

    /**
     * Return the icon output.
     *
     * @return string
     */
    public function output()
    {
        // @todo extend into the parent when ready
        return '<i ' . html_attributes([
            'class' => $this->class()
        ]) . '></i>';
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
            $this->type,
            $this->attr('attributes.class'),
        ]));
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
