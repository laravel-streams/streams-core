<?php namespace Anomaly\Streams\Platform\Addon\Module\Contract;

use Anomaly\Streams\Platform\Addon\Module\Module;

/**
 * Interface ModuleRepositoryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module\Contract
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
     * Mark a module as installed.
     *
     * @param Module $module
     * @return mixed
     */
    public function install(Module $module);

    /**
     * Mark a module as uninstalled.
     *
     * @param Module $module
     * @return mixed
     */
    public function uninstall(Module $module);
}
 