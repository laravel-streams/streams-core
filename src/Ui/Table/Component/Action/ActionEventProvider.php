<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class ActionEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action
 */
class ActionEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\Ui\Table\Event\TableWasPosted' => [
            'Anomaly\Streams\Platform\Ui\Table\Component\Action\Listener\ExecuteAction'
        ]
    ];

}
