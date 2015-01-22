<?php namespace Anomaly\Streams\Platform\Addon\Block;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class BlockEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Block
 */
class BlockEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\Addon\Block\Event\BlockWasRegistered' => [
            'Anomaly\Streams\Platform\Addon\Block\Listener\PutBlockInCollection'
        ]
    ];

}
