<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Module\Command\InstallModule;
use Anomaly\Streams\Platform\Addon\Module\Command\SyncModules;
use Anomaly\Streams\Platform\Addon\Module\Command\UninstallModule;
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
        $this->dispatch(new InstallModule($module));
    }

    /**
     * Uninstall a module.
     *
     * @param  $module
     * @return mixed
     */
    public function uninstall($module)
    {
        $this->dispatch(new UninstallModule($module));
    }

    /**
     * Sync modules to the database.
     */
    public function sync()
    {
        $this->dispatch(new SyncModules());
    }
}
