<?php namespace Anomaly\Streams\Platform\View;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class ViewEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\View
 */
class ViewEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\View\Event\ViewComposed' => [
            'Anomaly\Streams\Platform\View\Listener\DecorateData'
        ]
    ];

}
