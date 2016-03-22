<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Assignment\Command\UpdateAssignmentColumn;
use Anomaly\Streams\Platform\Field\Command\DeleteFieldAssignments;
use Anomaly\Streams\Platform\Field\Command\DeleteFieldTranslations;
use Anomaly\Streams\Platform\Field\Command\RenameFieldAssignments;
use Anomaly\Streams\Platform\Field\Command\UpdateFieldAssignments;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Field\Event\FieldWasCreated;
use Anomaly\Streams\Platform\Field\Event\FieldWasDeleted;
use Anomaly\Streams\Platform\Field\Event\FieldWasSaved;
use Anomaly\Streams\Platform\Field\Event\FieldWasUpdated;
use Anomaly\Streams\Platform\Support\Observer;

/**
 * Class FieldObserver
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field
 */
class FieldObserver extends Observer
{

    /**
     * Fired after creating a field.
     *
     * @param FieldInterface $model
     */
    public function created(FieldInterface $model)
    {
        $model->flushCache();

        $this->events->fire(new FieldWasCreated($model));
    }

    /**
     * Run before a record is updated.
     *
     * @param FieldInterface $model
     */
    public function updating(FieldInterface $model)
    {
        $this->dispatch(new RenameFieldAssignments($model));
    }

    /**
     * Fired after a field is updated.
     *
     * @param FieldInterface $model
     */
    public function updated(FieldInterface $model)
    {
        $model->flushCache();

        $this->dispatch(new UpdateFieldAssignments($model));

        $this->events->fire(new FieldWasUpdated($model));
    }

    /**
     * Fired after saving a field.
     *
     * @param FieldInterface $model
     */
    public function saved(FieldInterface $model)
    {
        $model->flushCache();
        $model->compileStreams();

        $this->events->fire(new FieldWasSaved($model));
    }

    /**
     * Fired just before deleting a field.
     *
     * @param FieldInterface $model
     */
    public function deleting(FieldInterface $model)
    {
        $this->dispatch(new DeleteFieldAssignments($model));
    }

    /**
     * Fired after a field has been deleted.
     *
     * @param FieldInterface $model
     */
    public function deleted(FieldInterface $model)
    {
        $model->flushCache();

        $this->dispatch(new DeleteFieldTranslations($model));

        $this->events->fire(new FieldWasDeleted($model));
    }
}
