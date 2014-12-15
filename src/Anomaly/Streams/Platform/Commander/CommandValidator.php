<?php namespace Anomaly\Streams\Platform\Commander;

use Laracasts\Commander\CommandBus;

/**
 * Class CommandValidator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class CommandValidator implements CommandBus
{

    /**
     * Execute a command validator.
     *
     * @param $command
     * @return mixed
     */
    public function execute($command)
    {
        $validator = get_class($command) . 'Validator';

        if (!class_exists($validator)) {
            return null;
        }

        return app()->make($validator)->handle($command);
    }
}
