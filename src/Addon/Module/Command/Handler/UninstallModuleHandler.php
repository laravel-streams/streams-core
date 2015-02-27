<?php namespace Anomaly\Streams\Platform\Addon\Module\Command\Handler;

use Anomaly\Streams\Platform\Addon\Module\Command\UninstallModule;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasUninstalled;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Illuminate\Console\Command;
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
     * The loaded modules.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * The service container.
     *
     * @var Command
     */
    protected $command;

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
     * @param Command          $command
     * @param Dispatcher       $dispatcher
     */
    public function __construct(ModuleCollection $modules, Command $command, Dispatcher $dispatcher)
    {
        $this->modules    = $modules;
        $this->command    = $command;
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
        $this->dispatcher->fire(new ModuleWasUninstalled($module));

        return true;
    }
}
