<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Module\Command\DisableModule;
use Anomaly\Streams\Platform\Addon\Module\Command\EnableModule;
use Anomaly\Streams\Platform\Addon\Module\Command\InstallModule;
use Anomaly\Streams\Platform\Addon\Module\Command\MigrateModule;
use Anomaly\Streams\Platform\Addon\Module\Command\UninstallModule;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class ModuleManager
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ModuleManager
{
    use DispatchesJobs;

    /**
     * Install a module.
     *
     * @param Module $module
     * @param bool   $seed
     */
    public function install(Module $module, $seed = false)
    {
        $this->dispatch(new InstallModule($module, $seed));
    }

    /**
     * Uninstall a module.
     *
     * @param Module $module
     */
    public function uninstall(Module $module)
    {
        $this->dispatch(new UninstallModule($module));
    }

    /**
     * Enable a module.
     *
     * @param Module $module
     * @param bool   $seed
     */
    public function enable(Module $module)
    {
        $this->dispatch(new EnableModule($module));
    }

    /**
     * Disable a module.
     *
     * @param Module $module
     */
    public function disable(Module $module)
    {
        $this->dispatch(new DisableModule($module));
    }

    /**
     * Migrate a module.
     *
     * @param Module $module
     * @param bool   $seed
     */
    public function migrate(Module $module, $seed = false)
    {
        $this->dispatch(new MigrateModule($module, $seed));
    }

}
