<?php namespace Anomaly\Streams\Platform\Stream\Command\Handler;

use Illuminate\Events\Dispatcher;

/**
 * Class RegisterListenersHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Command
 */
class RegisterListenersHandler
{

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Create a new RegisterListenersHandler instance.
     *
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->dispatcher->listen(
            'Anomaly\Streams\Platform\Stream\Event\StreamWasCreated',
            'Anomaly\Streams\Platform\Stream\Listener\StreamCreatedListener'
        );
        $this->dispatcher->listen(
            'Anomaly\Streams\Platform\Stream\Event\StreamWasSaved',
            'Anomaly\Streams\Platform\Stream\Listener\StreamSavedListener'
        );
        $this->dispatcher->listen(
            'Anomaly\Streams\Platform\Stream\Event\StreamWasDeleted',
            'Anomaly\Streams\Platform\Stream\Listener\StreamDeletedListener'
        );
    }
}
