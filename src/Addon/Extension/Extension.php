<?php

namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Addon;

/**
 * Class Extension
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Extension extends Addon
{

    /**
     * The provides string.
     *
     * @var null|string
     */
    protected $provides = null;

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * Set the provides string.
     *
     * @param $provides
     * @return $this
     */
    public function setProvides($provides)
    {
        $this->provides = $provides;

        return $this;
    }

    /**
     * Get the provides string.
     *
     * @return null|string
     */
    public function getProvides()
    {
        return $this->provides;
    }

    /**
     * Set the active flag.
     *
     * @param  $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the active flag.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Return the addon as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge(
            parent::toArray(),
            [
                'enabled'   => $this->isEnabled(),
                'installed' => $this->isInstalled(),
            ]
        );
    }
}
