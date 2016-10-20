<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class AssignmentModelTranslation
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class AssignmentModelTranslation extends EloquentModel
{

    /**
     * Do not use timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The cache minutes.
     *
     * @var int
     */
    protected $cacheMinutes = 99999;

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'streams_assignments_translations';
}
