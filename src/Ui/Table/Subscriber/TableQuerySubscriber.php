<?php namespace Anomaly\Streams\Platform\Ui\Table\Subscriber;

use Illuminate\Events\Dispatcher;

/**
 * Class TableQuerySubscriber
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Subscriber
 */
class TableQuerySubscriber
{

    /**
     * Subscribe TableBuildEvent listeners.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            'streams::table.query',
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Listener\TableQueryListener'
        );

        $events->listen(
            'streams::table.query',
            'Anomaly\Streams\Platform\Ui\Table\Component\View\Listener\TableQueryListener'
        );
    }
}
