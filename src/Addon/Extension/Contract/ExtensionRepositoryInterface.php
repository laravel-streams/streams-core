<?php namespace Anomaly\Streams\Platform\Addon\Extension\Contract;

/**
 * Interface ExtensionRepositoryInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension\Contract
 */
interface ExtensionRepositoryInterface
{

    /**
     * Return all extensions in the database.
     *
     * @return mixed
     */
    public function all();

    /**
     * Create a extension record.
     *
     * @param  $namespace
     * @return mixed
     */
    public function create($namespace);

    /**
     * Delete a extension record.
     *
     * @param  $namespace
     * @return mixed
     */
    public function delete($namespace);

    /**
     * Mark a extension as installed.
     *
     * @param  $namespace
     * @return mixed
     */
    public function install($namespace);

    /**
     * Mark a extension as uninstalled.
     *
     * @param  $namespace
     * @return mixed
     */
    public function uninstall($namespace);
}
