<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasUninstalled;
use Anomaly\Streams\Platform\Addon\Module\Module;
use App\Console\Kernel;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Events\Dispatcher;

/**
 * Class UninstallModule
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class UninstallModule implements SelfHandling
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
    public function handle(Kernel $console, Dispatcher $events)
    {
        $options = [
            '--addon' => $this->module->getNamespace()
        ];

        $console->call('migrate:reset', $options);
        $console->call('streams:cleanup');

        $events->fire(new ModuleWasUninstalled($this->module));
    }
}
