<?php namespace Streams\Core\Field\Observer;

use Streams\Core\Model\Observer\EloquentObserver;

class FieldObserver extends EloquentObserver
{
    /**
     * Called after deleting a record.
     *
     * @param $model
     */
    public function deleted($model)
    {
        parent::deleted($model);

        $model->assignments()->delete();

        $model->type->destroy();
    }
}
