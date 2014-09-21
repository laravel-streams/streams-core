<?php namespace Streams\Platform\Assignment\Observer;

use Streams\Platform\Model\Observer\EloquentObserver;

class AssignmentObserver extends EloquentObserver
{
    /**
     * Run after creating a record.
     *
     * @param $model
     */
    public function created($model)
    {
        parent::created($model);

        $model->stream->save();

        $model->newSchema()->create();
    }

    /**
     * Run after saving a record.
     *
     * @param $model
     */
    public function saved($model)
    {
        parent::saved($model);

        $model->stream->save();
    }

    /**
     * Called after deleting a record.
     *
     * @param $model
     */
    public function deleted($model)
    {
        parent::deleted($model);

        $model->type->unassigned();

        $model->stream->save();

        $model->newSchema()->delete();
    }
}
