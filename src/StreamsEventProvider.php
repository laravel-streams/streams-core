<?php namespace Anomaly\Streams\Platform;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class StreamsEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform
 */
class StreamsEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\Application\Event\ApplicationHasLoaded' => [
            'Anomaly\Streams\Platform\Addon\Module\Listener\DetectActiveModule',
            'Anomaly\Streams\Platform\Application\Listener\CheckIfInstallerExists',
            'Anomaly\Streams\Platform\Ui\ControlPanel\Listener\LoadControlPanel',
            'Anomaly\Streams\Platform\Ui\Breadcrumb\Listener\GuessBreadcrumbs',
            'Anomaly\Streams\Platform\Ui\Breadcrumb\Listener\LoadBreadcrumbs'
        ],
        'Anomaly\Streams\Platform\Event\Ready'                            => [
            'Anomaly\Streams\Platform\Addon\Theme\Listener\LoadCurrentTheme' => -100
        ],
        'Anomaly\Streams\Platform\Addon\Event\AddonsHaveRegistered'       => [
            'Anomaly\Streams\Platform\Asset\Listener\AddAddonPaths',
            'Anomaly\Streams\Platform\Image\Listener\AddAddonPaths'
        ],
        'Anomaly\Streams\Platform\View\Event\ViewComposed'                => [
            'Anomaly\Streams\Platform\View\Listener\DecorateData',
            'Anomaly\Streams\Platform\View\Listener\LoadTemplateData'
        ],
        'Anomaly\Streams\Platform\View\Event\TemplateDataIsLoading'       => [
            'Anomaly\Streams\Platform\View\Listener\LoadGlobalData'
        ],
        'Anomaly\Streams\Platform\Addon\Plugin\Event\PluginWasRegistered' => [
            'Anomaly\Streams\Platform\Addon\Plugin\Listener\AddPluginToTwig'
        ],
        'Anomaly\Streams\Platform\Ui\Table\Event\TableIsQuerying'         => [
            'Anomaly\Streams\Platform\Ui\Table\Component\View\Listener\ApplyView',
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Listener\FilterResults'
        ]
    ];

    /**
     * Register the application's event listeners.
     *
     * @param  Dispatcher $events
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $key => $listener) {

                if (is_integer($listener)) {
                    $listener = $key;
                    $priority = $listener;
                } else {
                    $priority = 0;
                }

                $events->listen($event, $listener, $priority);
            }
        }

        foreach ($this->subscribe as $subscriber) {
            $events->subscribe($subscriber);
        }
    }
}
