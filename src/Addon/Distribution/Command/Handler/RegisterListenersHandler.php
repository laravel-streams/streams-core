<?php namespace Anomaly\Streams\Platform\Addon\Distribution\Command\Handler;

use Illuminate\Events\Dispatcher;

/**
 * Class RegisterListenersHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Distribution\Command
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
    function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->dispatcher->listen(
            'Anomaly\Streams\Platform\Addon\Distribution\Event\DistributionWasRegistered',
            'Anomaly\Streams\Platform\Addon\Distribution\Listener\PutDistributionInCollection'
        );
    }
}
