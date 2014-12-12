<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

/**
 * Class SetModuleStatesCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Command
 */
class SetModuleStatesCommandHandler
{
    /**
     * Handle the command.
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
