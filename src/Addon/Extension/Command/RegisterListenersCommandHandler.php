<?php namespace Anomaly\Streams\Platform\Addon\Extension\Command;

use Illuminate\Events\Dispatcher;

/**
 * Class RegisterListenersCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Extension\Command
 */
class RegisterListenersCommandHandler
{

    protected $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    
    public function handle()
    {
        $this->dispatcher->listen(
            'Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasRegistered',
            'Anomaly\Streams\Platform\Addon\Extension\Listener\PutExtensionInCollection'
        );
        $this->dispatcher->listen(
            'Anomaly\Streams\Platform\Addon\Event\AddonWasRegistered',
            'Anomaly\Streams\Platform\Addon\Extension\Listener\FireExtensionWasRegistered'
        );
    }
}
