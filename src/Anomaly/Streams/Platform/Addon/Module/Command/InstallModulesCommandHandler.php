<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\ModuleManager;

/**
 * Class InstallModulesCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Command
 */
class InstallModulesCommandHandler
{
    /**
     * The module manager.
     *
     * @var \Anomaly\Streams\Platform\Addon\Module\ModuleManager
     */
    protected $manager;

    /**
     * Create a new InstallModulesCommandHandler instance.
     *
     * @param ModuleManager $service
     */
    function __construct(ModuleManager $service)
    {
        $this->manager = $service;
    }

    /**
     * Install the all registered modules.
     */
    public function handle()
    {
        foreach (app('streams.modules')->all() as $module) {
            $this->manager->install($module);
        }
    }
}
