<?php namespace Anomaly\Streams\Platform\Http\Controller;

use Anomaly\Streams\Platform\Lock\Contract\LockRepositoryInterface;
use Illuminate\Session\Store;

/**
 * Class LocksController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LocksController extends AdminController
{

    /**
     * Touch the locks for a given URL by session ID.
     *
     * @param LockRepositoryInterface $locks
     * @param Store                   $session
     */
    public function touch(LockRepositoryInterface $locks, Store $session)
    {
        $locks->touchLocks($this->url->previous(), $session->getId());
    }

    /**
     * Release the locks for a given URL by session ID.
     *
     * @param LockRepositoryInterface $locks
     * @param Store                   $session
     */
    public function release(LockRepositoryInterface $locks, Store $session)
    {
        $locks->releaseLocks($this->url->previous(), $session->getId());
    }

}
