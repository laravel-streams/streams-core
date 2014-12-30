<?php namespace Anomaly\Streams\Platform\Ui\Form\Subscriber;

use Illuminate\Events\Dispatcher;

/**
 * Class FormBuildSubscriber
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Subscriber
 */
class FormBuildSubscriber
{

    /**
     * Subscribe FormBuildEvent listeners.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        /*$events->listen(
            'streams::table.build',
            'Anomaly\Streams\Platform\Ui\Form\Listener\FormBuildListener'
        );*/
    }
}
