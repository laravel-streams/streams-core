<?php

namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasSaved;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasUpdated;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasCreated;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasDeleted;
use Anomaly\Streams\Platform\Assignment\Command\AddAssignmentColumn;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Assignment\Command\DropAssignmentColumn;
use Anomaly\Streams\Platform\Assignment\Command\UpdateAssignmentColumn;
use Anomaly\Streams\Platform\Support\Observer;

/**
 * Class AssignmentObserver
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AssignmentObserver extends Observer
{

    /**
     * Fired before creating an assignment.
     *
     * @param AssignmentInterface|AssignmentModel $model
     */
    public function creating(AssignmentInterface $model)
    {
        $model->sort_order = $model->newQuery()->count('id') + 1;
    }

    /**
     * Run after a record is created.
     *
     * @param AssignmentInterface $model
     */
    public function created(AssignmentInterface $model)
    {
        app(AssignmentSchema::class)->addColumn($model);
        app(AssignmentSchema::class)->addIndex($model);

        $this->events->dispatch(new AssignmentWasCreated($model));
    }

    /**
     * Run after a record is updated.
     *
     * @param AssignmentInterface $model
     */
    public function updated(AssignmentInterface $model)
    {
        $this->dispatchNow(new UpdateAssignmentColumn($model));

        $this->events->dispatch(new AssignmentWasUpdated($model));
    }

    /**
     * Run after saving a record.
     *
     * @param AssignmentInterface $model
     */
    public function saved(AssignmentInterface $model)
    {
        $this->events->dispatch(new AssignmentWasSaved($model));
    }

    /**
     * Run after a record has been deleted.
     *
     * @param AssignmentInterface $model
     */
    public function deleted(AssignmentInterface $model)
    {
        $this->dispatchNow(new DropAssignmentColumn($model));

        $this->events->dispatch(new AssignmentWasDeleted($model));
    }
}
