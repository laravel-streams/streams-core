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
     * @param  $slug
     * @return mixed
     */
    public function create($slug);

    /**
     * Delete a extension record.
     *
     * @param  $slug
     * @return mixed
     */
    public function delete($slug);

    /**
     * Mark a extension as installed.
     *
     * @param  $slug
     * @return mixed
     */
    public function install($slug);

    /**
     * Mark a extension as uninstalled.
     *
     * @param  $slug
     * @return mixed
     */
    public function uninstall($slug);
}
