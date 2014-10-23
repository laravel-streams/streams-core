<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Model\EloquentObserver;

class AssignmentObserver extends EloquentObserver
{
    /**
     * Run before attempting to save a record.
     *
     * @param $model
     * @return bool
     */
    public function saving($model)
    {
        parent::saving($model);

        return true;
    }

    /**
     * Run after saving a record.
     *
     * @param $model
     */
    public function saved($model)
    {
        parent::saved($model);
    }

    /**
     * Run before a record is updated.
     *
     * @param $model
     */
    public function updating($model)
    {
        parent::updating($model);
    }

    /**
     * Run after a record has been updated.
     *
     * @param $model
     */
    public function updated($model)
    {
        parent::updated($model);
    }

    /**
     * Run before creating a record.
     *
     * @param $model
     */
    public function creating($model)
    {
        parent::creating($model);
    }

    /**
     * Run after a record is created.
     *
     * @param $model
     */
    public function created($model)
    {
        parent::created($model);
    }

    /**
     * Run before deleting a record.
     *
     * @param $model
     */
    public function deleting($model)
    {
        parent::deleting($model);
    }

    /**
     * Run after a record has been deleted.
     *
     * @param $model
     */
    public function deleted($model)
    {
        parent::deleted($model);
    }

    /**
     * Run before restoring a record.
     *
     * @param $model
     */
    public function restoring($model)
    {
        parent::restoring($model);
    }

    /**
     * Run after a record has been restored.
     *
     * @param $model
     */
    public function restored($model)
    {
        parent::restored($model);
    }
}
