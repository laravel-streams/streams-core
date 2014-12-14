<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Module;

/**
 * Class DetectActiveModuleCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Command
 */
class DetectActiveModuleCommandHandler
{
    /**
     * Detect the active module and setup our
     * environment with it.
     */
    public function handle()
    {
        $module = null;

        /**
         * If we are in the admin the second segment
         * MUST be the active module's slug.
         */
        if (app('request')->segment(1) == 'admin') {
            $module = app('streams.modules')->findBySlug(app('request')->segment(2));
        }

        if ($module instanceof Module) {

            $module->setActive(true);

            app('view')->addNamespace('module', $module->getPath('resources/views'));
            app('streams.asset')->addNamespace('module', $module->getPath('resources'));
            app('streams.image')->addNamespace('module', $module->getPath('resources'));
            app('translator')->addNamespace('module', $module->getPath('resources/lang'));
        }
    }
}
