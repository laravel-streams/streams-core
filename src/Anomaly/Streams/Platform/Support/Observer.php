<?php namespace Anomaly\Streams\Platform\Support;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;

/**
 * Class Observer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Observer
{

    use DispatchableTrait;

    /**
     * Run before creating a record.
     *
     * @param EloquentModel $model
     */
    public function creating($model)
    {
    }

    /**
     * Run after a record is created.
     *
     * @param EloquentModel $model
     */
    public function created($model)
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
    public function saving($model)
    {
        return true;
    }

    /**
     * Run after saving a record.
     *
     * @param EloquentModel $model
     */
    public function saved($model)
    {
    }

    /**
     * Run before a record is updated.
     *
     * @param EloquentModel $model
     */
    public function updating($model)
    {
    }

    /**
     * Run after a record has been updated.
     *
     * @param EloquentModel $model
     */
    public function updated($model)
    {
        $model->flushCacheCollection();
    }

    /**
     * Run before deleting a record.
     *
     * @param EloquentModel $model
     */
    public function deleting($model)
    {
    }

    /**
     * Run after a record has been deleted.
     *
     * @param EloquentModel $model
     */
    public function deleted($model)
    {
        $model->flushCacheCollection();
    }

    /**
     * Run before restoring a record.
     *
     * @param EloquentModel $model
     */
    public function restoring($model)
    {
    }

    /**
     * Run after a record has been restored.
     *
     * @param EloquentModel $model
     */
    public function restored($model)
    {
        $model->flushCacheCollection();
    }
}
 