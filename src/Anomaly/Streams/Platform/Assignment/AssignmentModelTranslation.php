<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Model\EloquentModel;

class AssignmentModelTranslation extends EloquentModel
{

    /**
     * Do not use timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table name.
     *
     *
     * @var string
     */
    protected $table = 'streams_assignments_translations';
}
 