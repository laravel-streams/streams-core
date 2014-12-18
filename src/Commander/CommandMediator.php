<?php namespace Anomaly\Streams\Platform\Commander;

use Laracasts\Commander\CommandBus;

/**
 * Class CommandMediator
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Support
 */
class CommandMediator implements CommandBus
{

    /**
     * Execute a command mediator.
     *
     * @param  $command
     * @return mixed
     */
    public function execute($command)
    {
        $mediator = get_class($command) . 'Mediator';

        if (!class_exists($mediator)) {
            return null;
        }

        return app()->make($mediator)->handle($command);
    }
}
