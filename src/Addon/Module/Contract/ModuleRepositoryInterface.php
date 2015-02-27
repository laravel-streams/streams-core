<?php namespace Anomaly\Streams\Platform\Addon\Module\Contract;

use Anomaly\Streams\Platform\Addon\Module\Module;

/**
 * Interface ModuleRepositoryInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Contract
 */
interface ModuleRepositoryInterface
{

    /**
     * Return all modules in the database.
     *
     * @return mixed
     */
    public function all();

    /**
     * Create a module record.
     *
     * @param Module $module
     */
    public function create(Module $module);

    /**
     * Delete a module record.
     *
     * @param Module $module
     */
    public function delete(Module $module);

    /**
     * Mark a module as installed.
     *
     * @param Module $module
     */
    public function install(Module $module);

    /**
     * Mark a module as uninstalled.
     *
     * @param Module $module
     */
    public function uninstall(Module $module);
}
