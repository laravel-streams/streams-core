<?php namespace Anomaly\Streams\Platform\Addon\Module\Listener;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Module\ModuleModel;

/**
 * Class SetModuleStates
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Listener
 */
class SetModuleStates
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
     * Create a new SetModuleStates instance.
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
        if (!env('INSTALLED')) {
            return;
        }

        $states = $this->model->where('installed', true)->get();

        $this->modules->setStates($states->all());
    }
}
