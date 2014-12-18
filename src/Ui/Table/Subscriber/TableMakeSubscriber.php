<?php namespace Anomaly\Streams\Platform\Ui\Table\Subscriber;

use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class TableMakeSubscriber
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Subscriber
 */
class TableMakeSubscriber
{

    /**
     * Register table make listeners.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen('streams::table.make', 'Anomaly\Streams\Platform\Ui\Table\Listener\TableMakeListener');
        $events->listen('streams::table.make', 'Anomaly\Streams\Platform\Ui\Table\Row\Listener\TableMakeListener');
        $events->listen('streams::table.make', 'Anomaly\Streams\Platform\Ui\Table\View\Listener\TableMakeListener');
        $events->listen('streams::table.make', 'Anomaly\Streams\Platform\Ui\Table\Filter\Listener\TableMakeListener');
        $events->listen('streams::table.make', 'Anomaly\Streams\Platform\Ui\Table\Header\Listener\TableMakeListener');
        $events->listen('streams::table.make', 'Anomaly\Streams\Platform\Ui\Table\Action\Listener\TableMakeListener');
    }
}
