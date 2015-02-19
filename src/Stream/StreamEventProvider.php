<?php namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class StreamEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream
 */
class StreamEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\Stream\Event\StreamWasCreated' => [
            'Anomaly\Streams\Platform\Stream\Listener\CreateTable',
            'Anomaly\Streams\Platform\Stream\Listener\Recompile'
        ],
        'Anomaly\Streams\Platform\Stream\Event\StreamWasDeleted' => [
            'Anomaly\Streams\Platform\Stream\Listener\DropTable'
        ],
        'Anomaly\Streams\Platform\Stream\Event\StreamWasSaved'   => [
            'Anomaly\Streams\Platform\Stream\Listener\Recompile'
        ]
    ];

}
