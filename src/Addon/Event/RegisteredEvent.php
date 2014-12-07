<?php namespace Anomaly\Streams\Platform\Addon\Event;

use Anomaly\Streams\Platform\Addon\Addon;

/**
 * Class RegisteredEvent
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Event
 */
class RegisteredEvent
{

    /**
     * The addon object.
     *
     * @var
     */
    protected $addon;

    /**
     * Create a new RegisteredEvent instance.
     *
     * @param Addon $addon
     */
    function __construct(Addon $addon)
    {
        $this->addon = $addon;
    }

    /**
     * Get the addon object.
     *
     * @return mixed
     */
    public function getAddon()
    {
        return $this->addon;
    }
}
 