<?php namespace Anomaly\Streams\Platform\Addon\Module\Command\Handler;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;

/**
 * Class SetModuleStatesCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class SetModuleStatesCommandHandler
{

    /**
     * The loaded modules.
     *
     * @var \Anomaly\Streams\Platform\Addon\Module\ModuleCollection
     */
    protected $modules;

    /**
     * Create a new SetModuleStatesCommandHandler instance.
     *
     * @param ModuleCollection $modules
     */
    public function __construct(ModuleCollection $modules)
    {
        $this->modules = $modules;
    }

    /**
     * Set the installed / enabled status of
     * all of the registered modules.
     */
    public function handle()
    {
        $states = app('db')
            ->table('addons_modules')
            ->where('installed', true)
            ->get();

        $this->modules->setStates($states);
    }
}
