<?php namespace Anomaly\Streams\Platform\Addon\Module\Command\Handler;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Module\ModuleModel;

/**
 * Class SetModuleStatesHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class SetModuleStatesHandler
{

    /**
     * The module model.
     *
     * @var ModuleModel
     */
    protected $model;

    /**
     * The loaded modules.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * Create a new SetModuleStatesHandler instance.
     *
     * @param ModuleCollection $modules
     * @param ModuleModel      $model
     */
    public function __construct(ModuleCollection $modules, ModuleModel $model)
    {
        $this->model   = $model;
        $this->modules = $modules;
    }

    /**
     * Set the installed / enabled status of
     * all of the registered modules.
     */
    public function handle()
    {
        $states = $this->model->where('installed', true)->get();

        $this->modules->setStates($states->all());
    }
}
