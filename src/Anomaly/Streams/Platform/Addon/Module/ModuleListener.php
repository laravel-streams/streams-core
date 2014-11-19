<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\AddonListener;
use Anomaly\Streams\Platform\Addon\Event\AllRegistered;
use Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleInstalledEvent;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleUninstalledEvent;

/**
 * Class ModuleListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module
 */
class ModuleListener extends AddonListener
{

    /**
     * When a module is installed update the database.
     *
     * @param ModuleInstalledEvent      $event
     * @param ModuleRepositoryInterface $modules
     */
    public function whenModuleInstalled(ModuleInstalledEvent $event, ModuleRepositoryInterface $modules)
    {
        $modules->install($event->getModule());
    }

    /**
     * When a module is uninstalled update the database.
     *
     * @param ModuleUninstalledEvent    $event
     * @param ModuleRepositoryInterface $modules
     */
    public function whenModuleUninstalled(ModuleUninstalledEvent $event, ModuleRepositoryInterface $modules)
    {
        $modules->uninstall($event->getModule());
    }

    /**
     * When all modules are registered - bind the installed / enabled
     * data from the database to the addon classes.
     *
     * @param AllRegistered $event
     */
    public function whenAllRegistered(AllRegistered $event)
    {
        if ($event->getType() == 'module') {

            if (app('streams.application')->isLocated()) {

                app('streams.modules')->setStates(app('db')->table('addons_modules')->where('is_installed', 1)->get());
            }
        }
    }
}
 