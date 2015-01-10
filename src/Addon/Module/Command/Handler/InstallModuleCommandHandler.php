<?php namespace Anomaly\Streams\Platform\Addon\Module\Command\Handler;

use Anomaly\Streams\Platform\Addon\Module\Command\InstallModuleCommand;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasInstalled;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Module\ModuleInstaller;
use Anomaly\Streams\Platform\Contract\InstallableInterface;
use Illuminate\Events\Dispatcher;

/**
 * Class InstallModuleCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class InstallModuleCommandHandler
{

    /**
     * The loaded modules.
     *
     * @var \Anomaly\Streams\Platform\Addon\Module\ModuleCollection
     */
    protected $modules;

    /**
     * The event dispatcher.
     *
     * @var \Illuminate\Events\Dispatcher
     */
    protected $dispatcher;

    /**
     * Create a new InstallModuleCommandHandler instance.
     *
     * @param ModuleCollection $modules
     * @param Dispatcher       $dispatcher
     */
    public function __construct(ModuleCollection $modules, Dispatcher $dispatcher)
    {
        $this->modules    = $modules;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Install a module.
     *
     * @param  InstallModuleCommand $command
     * @return bool
     */
    public function handle(InstallModuleCommand $command)
    {
        $module = $this->modules->findBySlug($command->getModule());

        if (!$module) {
            throw new \Exception("Module [$command->getModule()] not be found.");
        }

        if ($installer = $module->newInstaller()) {
            $this->runInstallers($module, $installer);
        }

        $this->dispatcher->fire(new ModuleWasInstalled($module));

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
     * @param  Module $module
     * @param         $installer
     * @return mixed
     */
    protected function resolveInstaller(Module $module, $installer)
    {
        return app()->make($installer, ['addon' => $module]);
    }
}
