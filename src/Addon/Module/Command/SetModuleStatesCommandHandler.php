<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

/**
 * Class SetModuleStatesCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class SetModuleStatesCommandHandler
{

    /**
     * Set the installed / enabled status of
     * all of the registered modules.
     */
    public function handle()
    {
        $states = app('db')
            ->table('addons_modules')
            ->where('installed', true)
            ->get();

        app('streams.modules')->setStates($states);
    }
}
