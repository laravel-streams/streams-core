<?php namespace Anomaly\Streams\Platform\Addon\Distribution\Command;

use Illuminate\Events\Dispatcher;

/**
 * Class RegisterListenersCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Distribution\Command
 */
class RegisterListenersCommandHandler
{

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Create a new RegisterListenersCommandHandler instance.
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
        $this->dispatcher->listen(
            'Anomaly\Streams\Platform\Addon\Event\AddonWasRegistered',
            'Anomaly\Streams\Platform\Addon\Distribution\Listener\FireDistributionWasRegisteredEvent'
        );
    }
}
