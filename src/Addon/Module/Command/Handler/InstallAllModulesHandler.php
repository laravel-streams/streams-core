<?php namespace Anomaly\Streams\Platform\Addon\Module\Command\Handler;

use Anomaly\Streams\Platform\Addon\Module\Command\InstallAllModules;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Module\ModuleManager;

/**
 * Class InstallAllModulesHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class InstallAllModulesHandler
{

    /**
     * The module manager.
     *
     * @var ModuleManager
     */
    protected $manager;

    /**
     * The loaded modules.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * Create a new InstallAllModulesHandler instance.
     *
     * @param ModuleCollection $modules
     * @param ModuleManager    $service
     */
    public function __construct(ModuleCollection $modules, ModuleManager $service)
    {
        $this->manager = $service;
        $this->modules = $modules;
    }

    /**
     * Handle the command.
     *
     * @param InstallAllModules $command
     */
    public function handle(InstallAllModules $command)
    {
        foreach ($this->modules->all() as $module) {
            $this->manager->install($module, $command->getSeed());
        }
    }
}
