<?php namespace Anomaly\Streams\Platform\Ui\Table\Subscriber;

use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class TablePostSubscriber
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Subscriber
 */
class TablePostSubscriber
{

    /**
     * Register table post listeners.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen('streams::table.post', 'Anomaly\Streams\Platform\Ui\Table\Action\Listener\TablePostListener');
    }
}
