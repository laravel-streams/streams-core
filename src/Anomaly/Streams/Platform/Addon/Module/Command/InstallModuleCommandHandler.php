<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasInstalledEvent;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;

/**
 * Class InstallModuleCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Command
 */
class InstallModuleCommandHandler
{

    use DispatchableTrait;

    /**
     * Handle the command.
     *
     * @param InstallModuleCommand $command
     * @return bool
     */
    public function handle(InstallModuleCommand $command)
    {
        $module = $command->getModule();

        if ($installer = $module->newInstaller()) {

            foreach (app($installer)->getInstallers() as $installer) {

                if (!str_contains($installer, '\\')) {

                    $installer = $this->guessInstaller($module, $installer);
                }

                app($installer)->install();
            }
        }

        $this->dispatch(new ModuleWasInstalledEvent($module));

        $module->fire('after_install');

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
 