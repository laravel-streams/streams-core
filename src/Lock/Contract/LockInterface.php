<?php namespace Anomaly\Streams\Platform\Lock\Contract;

/**
 * Interface LockInterface
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
interface LockInterface
{

    /**
     * Touch the locked at time.
     *
     * @return bool
     */
    public function touch();
    
}
