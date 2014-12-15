<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Event\AssignmentCreatedEvent;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentDeletedEvent;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentSavedEvent;
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
        app('events')->fire('streams::assignment.saved', new AssignmentSavedEvent($model));

        parent::saved($model);
    }

    /**
     * Run after an assignment is created.
     *
     * @param EloquentModel $model
     */
    public function created(EloquentModel $model)
    {
        app('events')->fire('streams::assignment.created', new AssignmentCreatedEvent($model));

        parent::created($model);
    }

    /**
     * Run after an assignment is deleted.
     *
     * @param EloquentModel $model
     */
    public function deleted(EloquentModel $model)
    {
        app('events')->fire('streams::assignment.deleted', new AssignmentDeletedEvent($model));

        parent::deleted($model);
    }
}
