<?php namespace Anomaly\Streams\Platform\Addon\Distribution\Listener;

use Anomaly\Streams\Platform\Addon\Distribution\DistributionCollection;
use Anomaly\Streams\Platform\Addon\Distribution\Event\DistributionWasRegistered;

/**
 * Class PutDistributionInCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Distribution\Listener
 */
class PutDistributionInCollection
{

    /**
     * The distribution collection.
     *
     * @var DistributionCollection
     */
    protected $distributions;

    /**
     * Create a new PutDistributionInCollection instance.
     *
     * @param DistributionCollection $distributions
     */
    public function __construct(DistributionCollection $distributions)
    {
        $this->distributions = $distributions;
    }

    /**
     * Handle the event.
     *
     * @param DistributionWasRegistered $event
     */
    public function handle(DistributionWasRegistered $event)
    {
        $distribution = $event->getDistribution();

        $this->distributions->put($distribution->getKey(), $distribution);
    }
}
