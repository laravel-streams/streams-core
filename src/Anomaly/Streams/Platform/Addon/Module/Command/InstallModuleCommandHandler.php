<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Event\ModuleInstalled;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleInstaller;
use Anomaly\Streams\Platform\Contract\InstallableInterface;
use Laracasts\Commander\Events\DispatchableTrait;

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
     * Install a module.
     *
     * @param InstallModuleCommand $command
     * @return bool
     */
    public function handle(InstallModuleCommand $command)
    {
        $module = $command->getModule();

        if ($installer = $module->newInstaller()) {
            $this->runInstallers($module, $installer);
        }

        $module->raise(new ModuleInstalled($module));

        $this->dispatchEventsFor($module);

        return true;
    }

    /**
     * Run the module's installers.
     *
     * @param Module          $module
     * @param ModuleInstaller $installer
     */
    protected function runInstallers(Module $module, ModuleInstaller $installer)
    {
        foreach ($installer->getInstallers() as $installer) {
            $installer = $this->resolveInstaller($module, $installer);

            $this->runInstaller($installer);
        }
    }

    /**
     * Run an installer.
     *
     * @param InstallableInterface $installer
     */
    protected function runInstaller(InstallableInterface $installer)
    {
        $installer->install();
    }

    /**
     * Resolve the installer.
     *
     * @param Module $module
     * @param        $installer
     * @return mixed
     */
    protected function resolveInstaller(Module $module, $installer)
    {
        if (!str_contains($installer, '\\')) {
            $installer = $this->guessInstaller($module, $installer);
        }

        return app($installer);
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
