<?php

namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Assignment\AssignmentSchema;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Field\Event\FieldWasCreated;
use Anomaly\Streams\Platform\Field\Event\FieldWasDeleted;
use Anomaly\Streams\Platform\Field\Event\FieldWasSaved;
use Anomaly\Streams\Platform\Field\Event\FieldWasUpdated;
use Anomaly\Streams\Platform\Support\Observer;

/**
 * Class FieldObserver
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
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
        event(new FieldWasCreated($model));
    }

    /**
     * Run before a record is updated.
     *
     * @param FieldInterface $model
     */
    public function updating(FieldInterface $model)
    {
        foreach ($model->assignments as $assignment) {
            app(AssignmentSchema::class)->renameColumn($assignment);
            app(AssignmentSchema::class)->updateIndex($assignment);
        }
    }

    /**
     * Fired after a field is updated.
     *
     * @param FieldInterface $model
     */
    public function updated(FieldInterface $model)
    {

        foreach ($this->field->assignments as $assignment) {

            $assignment->setRelation('field', $model);

            app(AssignmentSchema::class)->changeColumn($assignment);
            app(AssignmentSchema::class)->updateColumn($assignment);
        }

        event(new FieldWasUpdated($model));
    }

    /**
     * Fired after saving a field.
     *
     * @param FieldInterface $model
     */
    public function saved(FieldInterface $model)
    {
        event(new FieldWasSaved($model));
    }

    /**
     * Fired just before deleting a field.
     *
     * @param FieldInterface $model
     */
    public function deleting(FieldInterface $model)
    {
        foreach ($model->assignments as $assignment) {
            $assignment->delete();
        }
    }

    /**
     * Fired after a field has been deleted.
     *
     * @param FieldInterface $model
     */
    public function deleted(FieldInterface $model)
    {
        event(new FieldWasDeleted($model));
    }
}
