<?php

namespace Anomaly\Streams\Platform\Ui\Contract;

use Anomaly\Streams\Platform\Ui\Icon\IconRegistry;

/**
 * Interface ClassAttributeInterface
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
interface ClassAttributeInterface
{

    /**
     * Get the class.
     *
     * @return string
     */
    public function getClass();

    /**
     * Set the class.
     *
     * @param array $class
     * @return $this
     */
    public function setClass($class);

    /**
     * Return class HTML.
     *
     * @param string $class
     * @return null|string
     */
    public function class($class = null);
}
