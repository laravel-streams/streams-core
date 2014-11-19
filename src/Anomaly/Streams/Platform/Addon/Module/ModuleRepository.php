<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface;

/**
 * Class ModuleRepository
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module
 */
class ModuleRepository implements ModuleRepositoryInterface
{

    /**
     * The module model.
     *
     * @var
     */
    protected $model;

    /**
     * Create a new ModuleRepository instance.
     *
     * @param ModuleModel $model
     */
    function __construct(ModuleModel $model)
    {
        $this->model = $model;
    }

    /**
     * Mark a module as installed.
     *
     * @param Module $module
     * @return mixed
     */
    public function install(Module $module)
    {
        $module = $this->model->findBySlugOrCreate($module->getSlug());

        $module->is_installed = true;
        $module->is_enabled   = true;

        $module->save();
    }

    /**
     * Mark a module as uninstalled.
     *
     * @param Module $module
     * @return mixed
     */
    public function uninstall(Module $module)
    {
        $module = $this->model->findBySlug($module->getSlug());

        $module->is_installed = false;
        $module->is_enabled   = false;

        $module->save();
    }
}
 