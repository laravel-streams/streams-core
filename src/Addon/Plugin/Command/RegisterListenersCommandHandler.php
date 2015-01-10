<?php namespace Anomaly\Streams\Platform\Addon\Plugin\Command;

use Illuminate\Events\Dispatcher;

/**
 * Class RegisterListenersCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Plugin\Command
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
     * RegisterListenersCommandHandler instance.
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
            'Anomaly\Streams\Platform\Addon\Plugin\Event\PluginWasRegistered',
            'Anomaly\Streams\Platform\Addon\Plugin\Listener\PutPluginInCollection'
        );
    }
}
