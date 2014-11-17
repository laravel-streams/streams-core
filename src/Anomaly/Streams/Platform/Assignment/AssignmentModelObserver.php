<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasCreatedEvent;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasDeletedEvent;
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
        $model->stream->save();

        parent::saved($model);
    }

    /**
     * Run after a record is created.
     *
     * @param $model
     */
    public function created($model)
    {
        $this->dispatch(new AssignmentWasCreatedEvent($model));

        parent::created($model);
    }

    /**
     * Run after a record has been deleted.
     *
     * @param $model
     */
    public function deleted($model)
    {
        $this->dispatch(new AssignmentWasDeletedEvent($model));

        parent::deleted($model);
    }
}
