<?php namespace Anomaly\Streams\Platform\Lock;

use Anomaly\Streams\Platform\Lock\Contract\LockInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;

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
     * No updated timestamp.
     */
    const UPDATED_AT = null;

    /**
     * The timestamps flag.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The model table.
     *
     * @var string
     */
    protected $table = 'streams_locks';

}
