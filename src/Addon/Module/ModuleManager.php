<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Laracasts\Commander\CommanderTrait;

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

    use CommanderTrait;

    /**
     * Install a module.
     *
     * @param  $module
     * @return mixed
     */
    public function install($module)
    {
        return $this->execute(
            'Anomaly\Streams\Platform\Addon\Module\Command\InstallModuleCommand',
            compact('module')
        );
    }

    /**
     * Uninstall a module.
     *
     * @param  $module
     * @return mixed
     */
    public function uninstall($module)
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
