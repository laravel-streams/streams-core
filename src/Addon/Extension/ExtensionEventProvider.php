<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class ExtensionEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Extension
 */
class ExtensionEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasRegistered'  => [
            'Anomaly\Streams\Platform\Addon\Extension\Listener\PutExtensionInCollection'
        ],
        'Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasInstalled'   => [
            'Anomaly\Streams\Platform\Addon\Extension\Listener\MarkExtensionInstalled'
        ],
        'Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasUninstalled' => [
            'Anomaly\Streams\Platform\Addon\Extension\Listener\MarkExtensionUninstalled'
        ]
    ];

}
