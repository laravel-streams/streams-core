<?php namespace Anomaly\Streams\Platform\Ui\Table\Subscriber;

use Illuminate\Events\Dispatcher;

/**
 * Class TableMakeSubscriber
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Subscriber
 */
class TableMakeSubscriber
{

    /**
     * Subscribe TableMakeEvent listeners.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            'streams::table.make',
            'Anomaly\Streams\Platform\Ui\Table\Listener\TableMakeListener'
        );

        $events->listen(
            'streams::table.make',
            'Anomaly\Streams\Platform\Ui\Table\Component\View\Listener\TableMakeListener'
        );

        $events->listen(
            'streams::table.make',
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Listener\TableMakeListener'
        );

        $events->listen(
            'streams::table.make',
            'Anomaly\Streams\Platform\Ui\Table\Component\Column\Listener\TableMakeListener'
        );

        $events->listen(
            'streams::table.make',
            'Anomaly\Streams\Platform\Ui\Table\Component\Button\Listener\TableMakeListener'
        );

        $events->listen(
            'streams::table.make',
            'Anomaly\Streams\Platform\Ui\Table\Component\Action\Listener\TableMakeListener'
        );
    }
}
