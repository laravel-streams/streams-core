<?php namespace Anomaly\Streams\Platform\Addon\Module\Contract;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleModel;
use Anomaly\Streams\Platform\Model\EloquentCollection;

/**
 * Interface ModuleRepositoryInterface
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
interface ModuleRepositoryInterface
{

    /**
     * Return all modules in the database.
     *
     * @return EloquentCollection
     */
    public function all();

    /**
     * Create a module record.
     *
     * @param  Module $module
     * @return bool
     */
    public function create(Module $module);

    /**
     * Delete a module record.
     *
     * @param  Module      $module
     * @return ModuleModel
     */
    public function delete(Module $module);

    /**
     * Mark a module as installed.
     *
     * @param  Module $module
     * @return bool
     */
    public function install(Module $module);

    /**
     * Mark a module as uninstalled.
     *
     * @param  Module $module
     * @return bool
     */
    public function uninstall(Module $module);

    /**
     * Mark a module as disabled.
     *
     * @param  Module $module
     * @return bool
     */
    public function disable(Module $module);

    /**
     * Mark a module as enabled.
     *
     * @param  Module $module
     * @return bool
     */
    public function enabled(Module $module);
}
