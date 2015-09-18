<?php

namespace Anomaly\Streams\Platform\Application\Command;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class ConfigureCommandBus.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class ConfigureCommandBus implements SelfHandling
{
    /**
     * Handle the command.
     */
    public function handle(Dispatcher $bus)
    {
        /*
         * Customize command to handler mapping.
         */
        $bus->mapUsing(
            function ($command) {

                /*
                 * If the command is self handling then
                 * return the handle method as defined
                 * by the interface.
                 */
                if ($command instanceof SelfHandling) {
                    return get_class($command).'@handle';
                }

                /*
                 * Otherwise the handler is in the Handler
                 * directory found in the commands directory
                 * and the class is appended with "Handler".
                 */
                $handler = explode('\\', get_class($command));

                array_splice($handler, count($handler) - 1, 0, 'Handler');

                return implode('\\', $handler).'Handler@handle';
            }
        );
    }
}
