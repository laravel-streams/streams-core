<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Event\AssignmentCreated;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentDeleted;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentSaved;
use Anomaly\Streams\Platform\Model\EloquentModel;
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
     * @param EloquentModel $model
     */
    public function saved(EloquentModel $model)
    {
        $model->raise(new AssignmentSaved($model));

        parent::saved($model);
    }

    /**
     * Run after an assignment is created.
     *
     * @param EloquentModel $model
     */
    public function created(EloquentModel $model)
    {
        $model->raise(new AssignmentCreated($model));

        parent::created($model);
    }

    /**
     * Run after an assignment is deleted.
     *
     * @param EloquentModel $model
     */
    public function deleted(EloquentModel $model)
    {
        $model->raise(new AssignmentDeleted($model));

        parent::deleted($model);
    }
}
