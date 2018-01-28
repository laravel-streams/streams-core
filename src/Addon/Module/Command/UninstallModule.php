<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasUninstalled;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Console\Kernel;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class UninstallModule
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
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
            '--force' => true
        ];

        $console->call('migrate:reset', $options);
        $console->call('streams:destroy', ['namespace' => $this->module->getSlug()]);
        $console->call('streams:cleanup');

        $modules->uninstall($this->module);

        $this->module->fire('uninstalled');

        $events->fire(new ModuleWasUninstalled($this->module));
    }
}
