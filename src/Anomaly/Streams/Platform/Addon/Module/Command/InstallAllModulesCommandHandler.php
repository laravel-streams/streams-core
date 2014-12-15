<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleManager;

/**
 * Class InstallAllModulesCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Command
 */
class InstallAllModulesCommandHandler
{
    /**
     * The module manager.
     *
     * @var \Anomaly\Streams\Platform\Addon\Module\ModuleManager
     */
    protected $manager;

    /**
     * Create a new InstallAllModulesCommandHandler instance.
     *
     * @param ModuleManager $service
     */
    function __construct(ModuleManager $service)
    {
        $this->manager = $service;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        foreach (app('streams.modules')->all() as $module) {
            $this->installModule($module);
        }
    }

    /**
     * Install a module.
     *
     * @param Module $module
     */
    protected function installModule(Module $module)
    {
        $this->manager->install($module->getSlug());
    }
}
