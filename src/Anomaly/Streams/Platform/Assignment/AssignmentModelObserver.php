<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Event\AssignmentCreatedEvent;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentDeletedEvent;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentSavedEvent;
use Anomaly\Streams\Platform\Model\EloquentModelObserver;

/**
 * Class AssignmentModelObserver
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment
 */
class AssignmentModelObserver extends EloquentModelObserver
{

    /**
     * Run after an assignment is saved.
     *
     * @param $model
     */
    public function saved($model)
    {
        $this->dispatch(new AssignmentSavedEvent($model));

        parent::saved($model);
    }

    /**
     * Run after an assignment is created.
     *
     * @param $model
     */
    public function created($model)
    {
        $this->dispatch(new AssignmentCreatedEvent($model));

        parent::created($model);
    }

    /**
     * Run after an assignment is deleted.
     *
     * @param $model
     */
    public function deleted($model)
    {
        $this->dispatch(new AssignmentDeletedEvent($model));

        parent::deleted($model);
    }
}
