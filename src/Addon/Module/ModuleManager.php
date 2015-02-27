<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Module\Command\InstallModule;
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
}
