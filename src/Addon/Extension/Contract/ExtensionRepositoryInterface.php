<?php namespace Anomaly\Streams\Platform\Addon\Extension\Contract;

use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionModel;
use Anomaly\Streams\Platform\Model\EloquentCollection;

/**
 * Interface ExtensionRepositoryInterface
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
interface ExtensionRepositoryInterface
{

    /**
     * Return all extensions in the database.
     *
     * @return EloquentCollection
     */
    public function all();

    /**
     * Create a extension record.
     *
     * @param  Extension $extension
     * @return bool
     */
    public function create(Extension $extension);

    /**
     * Delete a extension record.
     *
     * @param  Extension      $extension
     * @return ExtensionModel
     */
    public function delete(Extension $extension);

    /**
     * Mark a extension as installed.
     *
     * @param  Extension $extension
     * @return bool
     */
    public function install(Extension $extension);

    /**
     * Mark a extension as uninstalled.
     *
     * @param  Extension $extension
     * @return bool
     */
    public function uninstall(Extension $extension);

    /**
     * Mark a extension as disabled.
     *
     * @param  Extension $extension
     * @return bool
     */
    public function disable(Extension $extension);

    /**
     * Mark a extension as enabled.
     *
     * @param  Extension $extension
     * @return bool
     */
    public function enabled(Extension $extension);
}
