<?php namespace Anomaly\Streams\Platform\Addon\Plugin;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class PluginEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Plugin
 */
class PluginEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\Addon\Plugin\Event\PluginWasRegistered' => [
            'Anomaly\Streams\Platform\Addon\Plugin\Listener\PutPluginInCollection'
        ]
    ];

}
