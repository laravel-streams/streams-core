<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasSaved;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasUpdated;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasCreated;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasDeleted;
use Anomaly\Streams\Platform\Assignment\Command\AddAssignmentColumn;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Assignment\Command\BackupAssignmentData;
use Anomaly\Streams\Platform\Assignment\Command\DropAssignmentColumn;
use Anomaly\Streams\Platform\Assignment\Command\MoveAssignmentColumn;
use Anomaly\Streams\Platform\Assignment\Command\RestoreAssignmentData;
use Anomaly\Streams\Platform\Assignment\Command\UpdateAssignmentColumn;
use Anomaly\Streams\Platform\Assignment\Command\DeleteAssignmentTranslations;
use Anomaly\Streams\Platform\Support\Observer;

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
        $model->flushCache();
        $model->compileStream();

        $this->dispatch(new AddAssignmentColumn($model));

        $this->events->fire(new AssignmentWasCreated($model));
    }

    /**
     * Run before a record is updated.
     *
     * @param AssignmentInterface $model
     */
    public function updating(AssignmentInterface $model)
    {
        $this->dispatch(new BackupAssignmentData($model));
        $this->dispatch(new MoveAssignmentColumn($model));
        $this->dispatch(new RestoreAssignmentData($model));
    }

    /**
     * Run after a record is updated.
     *
     * @param AssignmentInterface $model
     */
    public function updated(AssignmentInterface $model)
    {
        $model->flushCache();
        $model->compileStream();

        $this->dispatch(new UpdateAssignmentColumn($model));

        $this->events->fire(new AssignmentWasUpdated($model));
    }

    /**
     * Run after saving a record.
     *
     * @param AssignmentInterface $model
     */
    public function saved(AssignmentInterface $model)
    {
        $model->flushCache();
        $model->compileStream();

        $this->events->fire(new AssignmentWasSaved($model));
    }

    /**
     * Run after a record has been deleted.
     *
     * @param AssignmentInterface $model
     */
    public function deleted(AssignmentInterface $model)
    {
        $model->flushCache();
        $model->compileStream();

        $this->dispatch(new DropAssignmentColumn($model));
        $this->dispatch(new DeleteAssignmentTranslations($model));

        $this->events->fire(new AssignmentWasDeleted($model));
    }
}
