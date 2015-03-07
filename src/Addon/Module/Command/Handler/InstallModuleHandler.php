<?php namespace Anomaly\Streams\Platform\Addon\Module\Command\Handler;

use Anomaly\Streams\Platform\Addon\Module\Command\InstallModule;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasInstalled;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use App\Console\Kernel;
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
     * Create a new InstallModuleHandler instance.
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
     * @param  InstallModule $kernel
     * @return bool
     */
    public function handle(InstallModule $kernel)
    {
        $module = $kernel->getModule();

        $options = [
            '--addon' => $module->getNamespace(),
            '--force' => true
        ];

        /*if ($kernel->getSeed()) {
            $options['--seed'] = true;
        }*/

        $this->command->call('migrate', $options);
        $this->dispatcher->fire(new ModuleWasInstalled($module));

        return true;
    }
}
