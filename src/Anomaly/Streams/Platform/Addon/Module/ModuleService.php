<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Module\Command\InstallModuleCommand;
use Anomaly\Streams\Platform\Addon\Module\Command\SyncModulesCommand;
use Anomaly\Streams\Platform\Addon\Module\Command\UninstallModuleCommand;
use Anomaly\Streams\Platform\Traits\CommandableTrait;

/**
 * Class ModuleService
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module
 */
class ModuleService
{

    use CommandableTrait;

    /**
     * Install a module.
     *
     * @param Module $module
     * @return mixed
     */
    public function install(Module $module)
    {
        return $this->execute(new InstallModuleCommand($module));
    }

    /**
     * Uninstall a module.
     *
     * @param Module $module
     * @return mixed
     */
    public function uninstall(Module $module)
    {
        return $this->execute(new UninstallModuleCommand($module));
    }

    /**
     * Sync modules to the database.
     */
    public function sync()
    {
        $this->execute(new SyncModulesCommand());
    }
}
