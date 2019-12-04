<?php

namespace Anomaly\Streams\Platform\Ui\Traits;

use Anomaly\Streams\Platform\Ui\Icon\IconRegistry;

/**
 * Trait HasClassAttribute
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait HasClassAttribute
{

    /**
     * The class attribtue.
     *
     * @var string
     */
    protected $class = null;

    /**
     * Get the class.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set the class.
     *
     * @param array $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Return class HTML.
     *
     * @param string $class
     * @return null|string
     */
    public function class($class = null)
    {
        return trim(implode(' ', array_filter([
            $class,
            $this->getClass()
        ])));
    }
}
