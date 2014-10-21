<?php namespace Anomaly\Streams\Platform\Model;

class EloquentObserver
{
    /**
     * Run before attempting to save a record.
     *
     * @param $model
     * @return bool
     */
    public function saving($model)
    {
        return true;
    }

    /**
     * Run after saving a record.
     *
     * @param $model
     */
    public function saved($model)
    {
    }

    /**
     * Run before a record is updated.
     *
     * @param $model
     */
    public function updating($model)
    {
    }

    /**
     * Run after a record has been updated.
     *
     * @param $model
     */
    public function updated($model)
    {
        $model->flushCacheCollection();
    }

    /**
     * Run before creating a record.
     *
     * @param $model
     */
    public function creating($model)
    {
    }

    /**
     * Run after a record is created.
     *
     * @param $model
     */
    public function created($model)
    {
        $model->flushCacheCollection();
    }

    /**
     * Run before deleting a record.
     *
     * @param $model
     */
    public function deleting($model)
    {
    }

    /**
     * Run after a record has been deleted.
     *
     * @param $model
     */
    public function deleted($model)
    {
        $model->flushCacheCollection();
    }

    /**
     * Run before restoring a record.
     *
     * @param $model
     */
    public function restoring($model)
    {
    }

    /**
     * Run after a record has been restored.
     *
     * @param $model
     */
    public function restored($model)
    {
        $model->flushCacheCollection();
    }
}
