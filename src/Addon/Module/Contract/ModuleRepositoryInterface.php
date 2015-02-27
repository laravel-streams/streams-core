<?php namespace Anomaly\Streams\Platform\Addon\Module\Contract;

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
     * @param  $namespace
     * @return mixed
     */
    public function create($namespace);

    /**
     * Delete a module record.
     *
     * @param  $namespace
     * @return mixed
     */
    public function delete($namespace);

    /**
     * Mark a module as installed.
     *
     * @param  $namespace
     * @return mixed
     */
    public function install($namespace);

    /**
     * Mark a module as uninstalled.
     *
     * @param  $namespace
     * @return mixed
     */
    public function uninstall($namespace);
}
