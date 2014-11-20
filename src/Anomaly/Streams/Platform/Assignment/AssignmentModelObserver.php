<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Event\AssignmentSavedEvent;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentCreatedEvent;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentDeletedEvent;
use Anomaly\Streams\Platform\Model\EloquentModelObserver;

class AssignmentModelObserver extends EloquentModelObserver
{

    /**
     * Run after saving a record.
     *
     * @param $model
     */
    public function saved($model)
    {
        $this->dispatch(new AssignmentSavedEvent($model));

        parent::saved($model);
    }

    /**
     * Run after a record is created.
     *
     * @param $model
     */
    public function created($model)
    {
        $this->dispatch(new AssignmentCreatedEvent($model));

        parent::created($model);
    }

    /**
     * Run after a record has been deleted.
     *
     * @param $model
     */
    public function deleted($model)
    {
        $this->dispatch(new AssignmentDeletedEvent($model));

        parent::deleted($model);
    }
}
