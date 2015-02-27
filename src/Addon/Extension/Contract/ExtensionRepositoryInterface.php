<?php namespace Anomaly\Streams\Platform\Addon\Extension\Contract;

use Anomaly\Streams\Platform\Addon\Extension\Extension;

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
     * @param Extension $extension
     */
    public function create(Extension $extension);

    /**
     * Delete a extension record.
     *
     * @param Extension $extension
     */
    public function delete(Extension $extension);

    /**
     * Mark a extension as installed.
     *
     * @param Extension $extension
     */
    public function install(Extension $extension);

    /**
     * Mark a extension as uninstalled.
     *
     * @param Extension $extension
     */
    public function uninstall(Extension $extension);
}
