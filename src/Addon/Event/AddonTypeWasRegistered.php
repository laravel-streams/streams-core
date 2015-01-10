<?php namespace Anomaly\Streams\Platform\Addon\Event;

/**
 * Class AddonTypeWasRegistered
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Event
 */
class AddonTypeWasRegistered
{

    /**
     * The addon type of which has
     * been completely registered.
     *
     * @var string
     */
    protected $type;

    /**
     * Create a new AddonTypeWasRegistered instance.
     *
     * @param $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Get the addon type.
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }
}
