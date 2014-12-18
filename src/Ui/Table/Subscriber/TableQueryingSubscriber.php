<?php namespace Anomaly\Streams\Platform\Ui\Table\Subscriber;

use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class TableQueryingSubscriber
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Subscriber
 */
class TableQueryingSubscriber
{

    /**
     * Register table post listeners.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            'streams::table.querying',
            'Anomaly\Streams\Platform\Ui\Table\Filter\Listener\TableQueryingListener'
        );
    }
}
