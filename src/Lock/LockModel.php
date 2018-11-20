<?php namespace Anomaly\Streams\Platform\Lock;

use Anomaly\Streams\Platform\Lock\Contract\LockInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Carbon\Carbon;

/**
 * Class LockModel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LockModel extends EloquentModel implements LockInterface
{

    /**
     * The timestamps flag.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The model table.
     *
     * @var string
     */
    protected $table = 'streams_locks';

    /**
     * Touch the locked at time.
     *
     * @return bool
     */
    public function touch()
    {
        $this->locked_at = new Carbon();

        return $this->save();
    }

}
