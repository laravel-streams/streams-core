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
     * @param  $namespace
     * @return mixed
     */
    public function create($namespace)
    {
        $module = $this->model->newInstance();

        $module->namespace = $namespace;
        $module->installed = false;
        $module->enabled   = false;

        $module->save();

        return $module;
    }

    /**
     * Delete a module record.
     *
     * @param  $namespace
     * @return mixed
     */
    public function delete($namespace)
    {
        $module = $this->model->findByNamespace($namespace);

        if ($module) {
            $module->delete();
        }

        return $module;
    }

    /**
     * Mark a module as installed.
     *
     * @param  $namespace
     * @return mixed
     */
    public function install($namespace)
    {
        $module = $this->model->findByNamespaceOrNew($namespace);

        $module->installed = true;
        $module->enabled   = true;

        $module->save();
    }

    /**
     * Mark a module as uninstalled.
     *
     * @param  $namespace
     * @return mixed
     */
    public function uninstall($namespace)
    {
        $module = $this->model->findByNamespace($namespace);

        $module->installed = false;
        $module->enabled   = false;

        $module->save();
    }
}
