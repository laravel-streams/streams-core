<?php namespace Anomaly\Streams\Platform\Ui\Table\Subscriber;

use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class TableBuildSubscriber
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Subscriber
 */
class TableBuildSubscriber
{

    /**
     * Register table build listeners.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            'streams::table.build',
            'Anomaly\Streams\Platform\Ui\Table\Listener\TableBuildListener',
            100 // Do this first!
        );

        $events->listen(
            'streams::table.build',
            'Anomaly\Streams\Platform\Ui\Button\Listener\TableBuildListener'
        );

        $events->listen(
            'streams::table.build',
            'Anomaly\Streams\Platform\Ui\Table\View\Listener\TableBuildListener'
        );

        $events->listen(
            'streams::table.build',
            'Anomaly\Streams\Platform\Ui\Table\Filter\Listener\TableBuildListener'
        );

        $events->listen(
            'streams::table.build',
            'Anomaly\Streams\Platform\Ui\Table\Header\Listener\TableBuildListener'
        );

        $events->listen(
            'streams::table.build',
            'Anomaly\Streams\Platform\Ui\Table\Action\Listener\TableBuildListener'
        );

        $events->listen(
            'streams::table.build',
            'Anomaly\Streams\Platform\Ui\Table\Column\Listener\TableBuildListener'
        );
    }
}
