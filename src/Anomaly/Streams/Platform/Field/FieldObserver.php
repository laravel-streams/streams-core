<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Model\EloquentObserver;

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
