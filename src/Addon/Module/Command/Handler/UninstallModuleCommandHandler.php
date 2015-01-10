<?php namespace Anomaly\Streams\Platform\Addon\Module\Command\Handler;

use Anomaly\Streams\Platform\Addon\Module\Command\UninstallModuleCommand;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasUninstalled;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Module\ModuleInstaller;
use Anomaly\Streams\Platform\Contract\InstallableInterface;
use Illuminate\Events\Dispatcher;

/**
 * Class UninstallModuleCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class UninstallModuleCommandHandler
{

    /**
     * The loaded module.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Create a new UninstallModuleCommandHandler instance.
     *
     * @param ModuleCollection $modules
     * @param Dispatcher       $dispatcher
     */
    function __construct(ModuleCollection $modules, Dispatcher $dispatcher)
    {
        $this->modules    = $modules;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle the command.
     *
     * @param  UninstallModuleCommand $command
     * @return bool
     */
    public function handle(UninstallModuleCommand $command)
    {
        $module = $this->modules->findBySlug($command->getModule());

        if (!$module instanceof Module) {
            throw new \Exception("Module [$command->getModule()] not be found.");
        }

        if ($installer = $module->newInstaller()) {
            $this->runInstallers($module, $installer);
        }

        $this->dispatcher->fire(new ModuleWasUninstalled($module));

        return true;
    }

    /**
     * Run the installers.
     *
     * @param Module          $module
     * @param ModuleInstaller $installer
     */
    protected function runInstallers(Module $module, ModuleInstaller $installer)
    {
        foreach ($installer->getInstallers() as $installer) {
            $installer = $this->resolveInstaller($module, $installer);

            $this->runUninstall($installer);
        }
    }

    /**
     * Run the installer's uninstall method.
     *
     * @param InstallableInterface $installer
     */
    protected function runUninstall(InstallableInterface $installer)
    {
        $installer->uninstall();
    }

    /**
     * Resolve the installer.
     *
     * @param  Module $module
     * @param         $installer
     * @return mixed
     */
    protected function resolveInstaller(Module $module, $installer)
    {
        return app()->make($installer, ['addon' => $module]);
    }
}
