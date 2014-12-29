<?php namespace Anomaly\Streams\Platform\Ui\Table\Subscriber;

use Illuminate\Events\Dispatcher;

/**
 * Class TableLoadSubscriber
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Subscriber
 */
class TableLoadSubscriber
{

    /**
     * Subscribe TableLoadEvent listeners.
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
            'Anomaly\Streams\Platform\Ui\Table\Component\View\Listener\TableLoadListener'
        );

        $events->listen(
            'streams::table.load',
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Listener\TableLoadListener'
        );

        $events->listen(
            'streams::table.load',
            'Anomaly\Streams\Platform\Ui\Table\Component\Column\Listener\TableLoadListener'
        );

        $events->listen(
            'streams::table.load',
            'Anomaly\Streams\Platform\Ui\Table\Component\Button\Listener\TableLoadListener'
        );
    }
}
