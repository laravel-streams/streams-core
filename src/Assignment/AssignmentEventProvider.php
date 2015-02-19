<?php namespace Anomaly\Streams\Platform\Assignment;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class AssignmentEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment
 */
class AssignmentEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\Assignment\Event\AssignmentWasCreated' => [
            'Anomaly\Streams\Platform\Assignment\Listener\AddTableColumn'
        ],
        'Anomaly\Streams\Platform\Assignment\Event\AssignmentWasDeleted' => [
            'Anomaly\Streams\Platform\Assignment\Listener\DropTableColumn'
        ],
        'Anomaly\Streams\Platform\Assignment\Event\AssignmentWasSaved'   => [
            'Anomaly\Streams\Platform\Assignment\Listener\SaveStream'
        ]
    ];

}
