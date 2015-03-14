<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class DistributionEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Distribution
 */
class DistributionEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\Addon\Distribution\Event\DistributionWasRegistered' => [
            'Anomaly\Streams\Platform\Addon\Distribution\Listener\PutDistributionInCollection'
        ],
        'Anomaly\Streams\Platform\Addon\Event\AddonsRegistered'                       => [
            'Anomaly\Streams\Platform\Addon\Distribution\Listener\DetectActiveDistribution'
        ]
    ];

}
