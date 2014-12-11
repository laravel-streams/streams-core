<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Event\AssignmentCreated;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentDeleted;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentSaved;
use Anomaly\Streams\Platform\Model\EloquentObserver;

/**
 * Class AssignmentObserver
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment
 */
class AssignmentObserver extends EloquentObserver
{
    /**
     * Run after an assignment is saved.
     *
     * @param $model
     */
    public function saved($model)
    {
        $model->raise(new AssignmentSaved($model));

        parent::saved($model);
    }

    /**
     * Run after an assignment is created.
     *
     * @param $model
     */
    public function created($model)
    {
        $model->raise(new AssignmentCreated($model));

        parent::created($model);
    }

    /**
     * Run after an assignment is deleted.
     *
     * @param $model
     */
    public function deleted($model)
    {
        $model->raise(new AssignmentDeleted($model));

        parent::deleted($model);
    }
}
