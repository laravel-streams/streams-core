<?php

namespace Anomaly\Streams\Platform\Image\Concerns;

/**
 * Trait HasAlterations
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasAlterations
{
    
    /**
     * Get the alterations.
     *
     * @return array
     */
    public function getAlterations()
    {
        return $this->alterations;
    }

    /**
     * Set the alterations.
     *
     * @param  array $alterations
     * @return $this
     */
    public function setAlterations(array $alterations)
    {
        $this->alterations = $alterations;

        return $this;
    }

    /**
     * Add an alteration.
     *
     * @param  $method
     * @param  $arguments
     * @return $this
     */
    public function addAlteration($method, $arguments = [])
    {
        $this->alterations[$method] = $arguments;

        return $this;
    }

    /**
     * Return if alteration is applied.
     *
     * @param $method
     * @return bool
     */
    public function hasAlteration($method)
    {
        return array_key_exists($method, $this->getAlterations());
    }
    
    /**
     * Return if any alterations are applied.
     *
     * @param $method
     * @return bool
     */
    public function hasAlterations()
    {
        return ($this->alterations);
    }

}
