<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Event\ModuleUninstalledEvent;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleInstaller;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;

/**
 * Class UninstallModuleCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Command
 */
class UninstallModuleCommandHandler
{

    use DispatchableTrait;

    /**
     * Handle the command.
     *
     * @param UninstallModuleCommand $command
     * @return bool
     */
    public function handle(UninstallModuleCommand $command)
    {
        $module = $command->getModule();

        if ($installer = $module->newInstaller()) {

            $this->runInstaller($module, $installer);
        }

        $this->dispatch(new ModuleUninstalledEvent($module));

        return true;
    }

    /**
     * Run the installer.
     *
     * @param Module          $module
     * @param ModuleInstaller $installer
     */
    protected function runInstaller(Module $module, ModuleInstaller $installer)
    {
        foreach ($installer->getInstallers() as $installer) {

            if (!str_contains($installer, '\\')) {

                $installer = $this->guessInstaller($module, $installer);
            }

            app($installer)->uninstall();
        }
    }

    /**
     * Guess the installer if it's shorthand.
     *
     * @param Module $module
     * @param        $installer
     * @return string
     */
    protected function guessInstaller(Module $module, $installer)
    {
        $addon = new \ReflectionClass($module);

        return $addon->getNamespaceName() . '\Installer\\' . $installer;
    }
}
 