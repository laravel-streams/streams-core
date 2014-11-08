<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

/**
 * Class ModuleServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module
 */
class ModuleServiceProvider extends AddonServiceProvider
{

    /**
     * Bind database statuses to loaded modules.
     */
    protected function onAfterRegister()
    {
        app('streams.modules')->setStates(app('db')->table('addons_modules')->where('is_installed', 1)->get());
    }
}
