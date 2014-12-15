<?php namespace Anomaly\Streams\Platform\Model;

/**
 * Class EloquentObserver
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model
 */
class EloquentObserver
{

    /**
     * Run before creating a record.
     *
     * @param EloquentModel $model
     */
    public function creating(EloquentModel $model)
    {
    }

    /**
     * Run after a record is created.
     *
     * @param EloquentModel $model
     */
    public function created(EloquentModel $model)
    {
        $model->flushCacheCollection();
    }

    /**
     * Run before attempting to save a record.
     * Return false to cancel the operation.
     *
     * @param EloquentModel $model
     * @return bool
     */
    public function saving(EloquentModel $model)
    {
        return true;
    }

    /**
     * Run after saving a record.
     *
     * @param EloquentModel $model
     */
    public function saved(EloquentModel $model)
    {
    }

    /**
     * Run before a record is updated.
     *
     * @param EloquentModel $model
     */
    public function updating(EloquentModel $model)
    {
    }

    /**
     * Run after a record has been updated.
     *
     * @param EloquentModel $model
     */
    public function updated(EloquentModel $model)
    {
        $model->flushCacheCollection();
    }

    /**
     * Run before deleting a record.
     *
     * @param EloquentModel $model
     */
    public function deleting(EloquentModel $model)
    {
    }

    /**
     * Run after a record has been deleted.
     *
     * @param EloquentModel $model
     */
    public function deleted(EloquentModel $model)
    {
        $model->flushCacheCollection();
    }

    /**
     * Run before restoring a record.
     *
     * @param EloquentModel $model
     */
    public function restoring(EloquentModel $model)
    {
    }

    /**
     * Run after a record has been restored.
     *
     * @param EloquentModel $model
     */
    public function restored(EloquentModel $model)
    {
        $model->flushCacheCollection();
    }
}
