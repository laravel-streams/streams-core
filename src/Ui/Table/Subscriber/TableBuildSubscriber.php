<?php namespace Anomaly\Streams\Platform\Ui\Table\Subscriber;

use Illuminate\Events\Dispatcher;

/**
 * Class TableBuildSubscriber
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Subscriber
 */
class TableBuildSubscriber
{

    /**
     * Subscribe TableBuildEvent listeners.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            'streams::table.build',
            'Anomaly\Streams\Platform\Ui\Table\Listener\TableBuildListener'
        );

        $events->listen(
            'streams::table.build',
            'Anomaly\Streams\Platform\Ui\Table\Component\View\Listener\TableBuildListener'
        );

        $events->listen(
            'streams::table.build',
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Listener\TableBuildListener'
        );
    }
}
