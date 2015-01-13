<?php namespace Anomaly\Streams\Platform\Addon\Module\Command\Handler;

use Illuminate\Events\Dispatcher;

/**
 * Class RegisterListenersHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Command
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
            'Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasRegistered',
            'Anomaly\Streams\Platform\Addon\Module\Listener\PutModuleInCollection'
        );
        $this->dispatcher->listen(
            'Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasInstalled',
            'Anomaly\Streams\Platform\Addon\Module\Listener\MarkModuleInstalled'
        );
        $this->dispatcher->listen(
            'Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasUninstalled',
            'Anomaly\Streams\Platform\Addon\Module\Listener\MarkModuleUninstalled'
        );
    }
}
