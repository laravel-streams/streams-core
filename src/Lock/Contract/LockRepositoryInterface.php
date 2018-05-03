<?php namespace Anomaly\Streams\Platform\Lock\Contract;

use Anomaly\Streams\Platform\Model\Contract\EloquentRepositoryInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Interface LockRepositoryInterface
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
interface LockRepositoryInterface extends EloquentRepositoryInterface
{

    /**
     * Find a lock by model.
     *
     * @param EloquentModel $model
     * @return null|LockInterface
     */
    public function findByLockable(EloquentModel $model);

    /**
     * Clean up old lock files.
     */
    public function cleanup();

}
