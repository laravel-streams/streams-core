<?php

namespace Anomaly\Streams\Platform;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Listener\FilterResults;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Listener\ApplyView;
use Anomaly\Streams\Platform\Ui\Table\Event\TableIsQuerying;
use Anomaly\Streams\Platform\Support\Event\ViewComposed;
use Anomaly\Streams\Platform\Support\Listener\DecorateData;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class StreamsEventProvider
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StreamsEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        TableIsQuerying::class       => [
            ApplyView::class,
            FilterResults::class,
        ],
    ];

    /**
     * Register the application's event listeners.
     */
    public function boot()
    {
        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $key => $listener) {
                if (is_integer($listener)) {
                    $listener = $key;
                    $priority = $listener;
                } else {
                    $priority = 0;
                }

                app('events')->listen($event, $listener, $priority);
            }
        }

        foreach ($this->subscribe as $subscriber) {
            app('events')->subscribe($subscriber);
        }
    }
}
