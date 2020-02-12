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
     * Get the provides string.
     *
     * @return null|string
     */
    public function getProvides()
    {
        return $this->provides;
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
