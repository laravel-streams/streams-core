<?php namespace Anomaly\Streams\Platform\Ui\Table\Subscriber;

use Illuminate\Events\Dispatcher;

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
     * Subscribe TableBuildEvent listeners.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
    }
}
