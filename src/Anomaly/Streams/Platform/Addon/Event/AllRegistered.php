<?php namespace Anomaly\Streams\Platform\Addon\Event;

/**
 * Class AllRegistered
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Event
 */
class AllRegistered
{
    /**
     * The addon type.
     *
     * @var
     */
    protected $type;

    /**
     * Create a new AllRegistered instance.
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
