<?php namespace Anomaly\Streams\Platform\Addon\Event;

use Anomaly\Streams\Platform\Addon\Addon;

/**
 * Class AddonWasRegistered
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Event
 */
class AddonWasRegistered
{

    /**
     * The addon object.
     *
     * @var \Anomaly\Streams\Platform\Addon\Addon
     */
    protected $addon;

    /**
     * Create a new AddonWasRegistered instance.
     *
     * @param Addon $addon
     */
    public function __construct(Addon $addon)
    {
        $this->addon = $addon;
    }

    /**
     * Get the addon object.
     *
     * @return Addon
     */
    public function getAddon()
    {
        return $this->addon;
    }
}
