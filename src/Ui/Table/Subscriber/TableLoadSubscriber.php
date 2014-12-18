<?php namespace Anomaly\Streams\Platform\Ui\Table\Subscriber;

use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class TableLoadSubscriber
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Subscriber
 */
class TableLoadSubscriber
{

    /**
     * Register table build listeners.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            'streams::table.load',
            'Anomaly\Streams\Platform\Ui\Table\Listener\TableLoadListener'
        );

        $events->listen(
            'streams::table.load',
            'Anomaly\Streams\Platform\Ui\Table\Row\Listener\TableLoadListener',
            -100 // Do this last
        );
    }
}
