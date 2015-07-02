<?php namespace Anomaly\Streams\Platform\Addon\Module\Command\Handler;

use Anomaly\Streams\Platform\Addon\Module\Command\UninstallModule;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasUninstalled;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use App\Console\Kernel;
use Illuminate\Events\Dispatcher;

/**
 * Class UninstallModuleHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class UninstallModuleHandler
{

    /**
     * The service container.
     *
     * @var Kernel
     */
    protected $command;

    /**
     * The loaded modules.
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
     * Create a new UninstallModuleHandler instance.
     *
     * @param ModuleCollection $modules
     * @param Kernel           $kernel
     * @param Dispatcher       $dispatcher
     */
    public function __construct(ModuleCollection $modules, Kernel $kernel, Dispatcher $dispatcher)
    {
        $this->command    = $kernel;
        $this->modules    = $modules;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle the command.
     *
     * @param  UninstallModule $command
     * @return bool
     */
    public function handle(UninstallModule $command)
    {
        $module = $command->getModule();

        $options = [
            '--addon' => $module->getNamespace()
        ];

        $this->command->call('migrate:reset', $options);
        $this->command->call('streams:cleanup', $options);
        $this->dispatcher->fire(new ModuleWasUninstalled($module));

        return true;
    }
}
