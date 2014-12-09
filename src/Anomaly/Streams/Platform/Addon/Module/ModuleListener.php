<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\AddonListener;
use Anomaly\Streams\Platform\Addon\Event\AllRegistered;
use Anomaly\Streams\Platform\Addon\Module\Command\SetModuleStatesCommand;
use Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleInstalled;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleUninstalled;

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
     * @param ModuleInstalled      $event
     * @param ModuleRepositoryInterface $modules
     */
    public function whenModuleInstalled(ModuleInstalled $event, ModuleRepositoryInterface $modules)
    {
        $modules->install($event->getModule());
    }

    /**
     * When a module is uninstalled update the database.
     *
     * @param ModuleUninstalled    $event
     * @param ModuleRepositoryInterface $modules
     */
    public function whenModuleUninstalled(ModuleUninstalled $event, ModuleRepositoryInterface $modules)
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
        if ($event->getType() == 'module' and app('streams.application')->isLocated()) {

            $this->execute(new SetModuleStatesCommand());
        }
    }
}
 