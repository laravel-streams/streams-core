<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasCreated;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasDeleted;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasSaved;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Model\EloquentObserver;

/**
 * Class AssignmentObserver
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment
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
        $this->events->fire(new AssignmentWasSaved($model));

        parent::saved($model);
    }

    /**
     * Run after an assignment is created.
     *
     * @param EloquentModel $model
     */
    public function created(EloquentModel $model)
    {
        $this->events->fire(new AssignmentWasCreated($model));

        parent::created($model);
    }

    /**
     * Run after an assignment is deleted.
     *
     * @param EloquentModel $model
     */
    public function deleted(EloquentModel $model)
    {
        $this->events->fire(new AssignmentWasDeleted($model));

        parent::deleted($model);
    }
}
