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
     * @param  $slug
     * @return mixed
     */
    public function create($slug);

    /**
     * Delete a module record.
     *
     * @param  $slug
     * @return mixed
     */
    public function delete($slug);

    /**
     * Mark a module as installed.
     *
     * @param  $slug
     * @return mixed
     */
    public function install($slug);

    /**
     * Mark a module as uninstalled.
     *
     * @param  $slug
     * @return mixed
     */
    public function uninstall($slug);
}
