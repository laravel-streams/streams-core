<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Laracasts\Commander\CommanderTrait;

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

    use CommanderTrait;

    /**
     * Install a module.
     *
     * @param Module $module
     * @return mixed
     */
    public function install(Module $module)
    {
        return $this->execute(
            'Anomaly\Streams\Platform\Addon\Module\Command\InstallModuleCommand',
            compact('module')
        );
    }

    /**
     * Uninstall a module.
     *
     * @param Module $module
     * @return mixed
     */
    public function uninstall(Module $module)
    {
        return $this->execute(
            'Anomaly\Streams\Platform\Addon\Module\Command\UninstallModuleCommand',
            compact('module')
        );
    }

    /**
     * Sync modules to the database.
     */
    public function sync()
    {
        $this->execute('Anomaly\Streams\Platform\Addon\Module\Command\SyncModulesCommand');
    }
}
