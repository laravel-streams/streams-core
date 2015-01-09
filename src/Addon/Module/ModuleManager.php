<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Module\Command\InstallModuleCommand;
use Anomaly\Streams\Platform\Addon\Module\Command\SyncModulesCommand;
use Anomaly\Streams\Platform\Addon\Module\Command\UninstallModuleCommand;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class ModuleManager
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module
 */
class ModuleManager
{

    use DispatchesCommands;

    /**
     * Install a module.
     *
     * @param  $module
     * @return mixed
     */
    public function install($module)
    {
        $this->dispatch(new InstallModuleCommand($module));
    }

    /**
     * Uninstall a module.
     *
     * @param  $module
     * @return mixed
     */
    public function uninstall($module)
    {
        $this->dispatch(new UninstallModuleCommand($module));
    }

    /**
     * Sync modules to the database.
     */
    public function sync()
    {
        $this->dispatch(new SyncModulesCommand());
    }
}
