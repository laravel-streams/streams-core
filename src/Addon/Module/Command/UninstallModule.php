<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasUninstalled;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Events\Dispatcher;

class UninstallModule
{

    /**
     * The module to uninstall.
     *
     * @var Module
     */
    protected $module;

    /**
     * Create a new UninstallModule instance.
     *
     * @param Module $module
     */
    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    /**
     * Handle the command.
     *
     * @param Kernel     $console
     * @param Dispatcher $events
     */
    public function handle(Kernel $console, Dispatcher $events, ModuleRepositoryInterface $modules)
    {
        $this->module->fire('uninstalling');

        $options = [
            '--addon' => $this->module->getNamespace(),
        ];

        $console->call('migrate:reset', $options);
        $console->call('streams:destroy', ['namespace' => $this->module->getSlug()]);
        $console->call('streams:cleanup');

        $modules->uninstall($this->module);

        $this->module->fire('uninstalled');

        $events->fire(new ModuleWasUninstalled($this->module));
    }
}
