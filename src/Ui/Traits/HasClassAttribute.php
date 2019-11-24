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
     * @param array $class
     * @return null|string
     */
    public function class($class)
    {
        return trim(implode(' ', [
            $class,
            $this->getClass()
        ]));
    }
}
