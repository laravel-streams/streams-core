<?php namespace Anomaly\Streams\Platform\Addon\Module\Command\Handler;

use Anomaly\Streams\Platform\Addon\Module\Command\InstallModule;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasInstalled;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Illuminate\Console\Command;
use Illuminate\Events\Dispatcher;

/**
 * Class InstallModuleHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class InstallModuleHandler
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
     * Create a new InstallModuleHandler instance.
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
     * @param  InstallModule $command
     * @return bool
     */
    public function handle(InstallModule $command)
    {
        $module = $command->getModule();

        $options = [
            '--addon' => $module->getNamespace()
        ];

        if ($command->getSeed()) {
            $options[] = '--seed';
        }

        $this->command->call('migrate', $options);
        $this->dispatcher->fire(new ModuleWasInstalled($module));

        return true;
    }
}
