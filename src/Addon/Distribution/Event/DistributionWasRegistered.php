<?php namespace Anomaly\Streams\Platform\Addon\Distribution\Event;

use Anomaly\Streams\Platform\Addon\Distribution\Distribution;

/**
 * Class DistributionWasRegistered
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Distribution\Event
 */
class DistributionWasRegistered
{

    /**
     * The distribution object.
     *
     * @var Distribution
     */
    protected $distribution;

    /**
     * Create a new DistributionWasRegistered instance.
     *
     * @param Distribution $distribution
     */
    function __construct(Distribution $distribution)
    {
        $this->distribution = $distribution;
    }

    /**
     * Get the distribution.
     *
     * @return Distribution
     */
    public function getDistribution()
    {
        return $this->distribution;
    }
}
