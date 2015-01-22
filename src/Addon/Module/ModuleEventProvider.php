<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class ModuleEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Addon\Module
 */
class ModuleEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasRegistered'  => [
            'Anomaly\Streams\Platform\Addon\Module\Listener\PutModuleInCollection'
        ],
        'Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasInstalled'   => [
            'Anomaly\Streams\Platform\Addon\Module\Listener\MarkModuleInstalled'
        ],
        'Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasUninstalled' => [
            'Anomaly\Streams\Platform\Addon\Module\Listener\MarkModuleUninstalled'
        ]
    ];

}
