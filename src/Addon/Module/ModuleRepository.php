<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface;

/**
 * Class ModuleRepository
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module
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
    public function __construct(ModuleModel $model)
    {
        $this->model = $model;
    }

    /**
     * Return all modules in the database.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Create a module record.
     *
     * @param  $slug
     * @return mixed
     */
    public function create($slug)
    {
        $module = $this->model->newInstance();

        $module->slug      = $slug;
        $module->enabled   = false;
        $module->installed = false;

        $module->save();

        return $module;
    }

    /**
     * Delete a module record.
     *
     * @param  $slug
     * @return mixed
     */
    public function delete($slug)
    {
        $module = $this->model->findBySlug($slug);

        if ($module) {

            $module->delete();
        }

        return $module;
    }

    /**
     * Mark a module as installed.
     *
     * @param  $slug
     * @return mixed
     */
    public function install($slug)
    {
        $module = $this->model->findBySlugOrNew($slug);

        $module->installed = true;
        $module->enabled   = true;

        $module->save();
    }

    /**
     * Mark a module as uninstalled.
     *
     * @param  $slug
     * @return mixed
     */
    public function uninstall($slug)
    {
        $module = $this->model->findBySlug($slug);

        $module->installed = false;
        $module->enabled   = false;

        $module->save();
    }
}
