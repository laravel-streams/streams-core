<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasDisabled;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class DisableModule
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class DisableModule implements SelfHandling
{

    /**
     * The module to uninstall.
     *
     * @var Module
     */
    protected $module;

    /**
     * Create a new DisableModule instance.
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
     * @param ModuleRepositoryInterface $modules
     * @param Dispatcher                $events
     * @return bool
     */
    public function handle(ModuleRepositoryInterface $modules, Dispatcher $events)
    {
        $modules->disable($this->module);

        $events->fire(new ModuleWasDisabled($this->module));

        return true;
    }
}
