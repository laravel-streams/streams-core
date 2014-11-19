<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Event\ModuleUninstalledEvent;
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

            foreach (app($installer)->getInstallers() as $installer) {

                if (!str_contains($installer, '\\')) {

                    $installer = $this->guessInstaller($module, $installer);
                }

                app($installer)->uninstall();
            }
        }

        $this->dispatch(new ModuleUninstalledEvent($module));

        $module->fire('after_uninstall');

        return true;
    }

    /**
     * Guess the installer if it's shorthand.
     *
     * @param $module
     * @param $installer
     * @return string
     */
    protected function guessInstaller($module, $installer)
    {
        $addon = new \ReflectionClass($module);

        return $addon->getNamespaceName() . '\Installer\\' . $installer;
    }
}
 