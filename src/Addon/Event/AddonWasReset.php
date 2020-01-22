<?php

namespace Anomaly\Streams\Platform\Addon\Event;

use Anomaly\Streams\Platform\Addon\Addon;

/**
 * Class AddonWasReset
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class AddonWasReset
{

    /**
     * The addon instance.
     *
     * @var Addon
     */
    protected $addon;

    /**
     * Create a new AddonWasReset instance.
     *
     * @param Addon $addon
     */
    public function __construct(Addon $addon)
    {
        $this->addon = $addon;
    }

    /**
     * Get the addon instance.
     *
     * @return Addon
     */
    public function getAddon()
    {
        return $this->addon;
    }
}
