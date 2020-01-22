<?php

namespace Anomaly\Streams\Platform\Addon\Contract;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Model\Contract\EloquentRepositoryInterface;
use Anomaly\Streams\Platform\Model\EloquentCollection;

/**
 * Interface AddonRepositoryInterface
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
interface AddonRepositoryInterface extends EloquentRepositoryInterface
{

    /**
     * Mark an addon as installed.
     *
     * @param  Addon $addon
     * @return bool
     */
    public function install(Addon $addon);

    /**
     * Mark an addon as uninstalled.
     *
     * @param  Addon $addon
     * @return bool
     */
    public function uninstall(Addon $addon);

    /**
     * Mark an addon as disabled.
     *
     * @param  Addon $addon
     * @return bool
     */
    public function disable(Addon $addon);

    /**
     * Mark an addon as enabled.
     *
     * @param  Addon $addon
     * @return bool
     */
    public function enable(Addon $addon);
}
