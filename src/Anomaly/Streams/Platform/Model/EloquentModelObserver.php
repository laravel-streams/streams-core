<?php namespace Anomaly\Streams\Platform\Model;

use Laracasts\Commander\Events\DispatchableTrait;

/**
 * Class EloquentModelObserver
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model
 */
class EloquentModelObserver
{

    use DispatchableTrait;

    /**
     * Run before creating a record.
     *
     * @param EloquentModel $model
     */
    public function creating($model)
    {
        $this->dispatchEventsFor($model);
    }

    /**
     * Run after a record is created.
     *
     * @param EloquentModel $model
     */
    public function created($model)
    {
        $this->dispatchEventsFor($model);

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
        $this->dispatchEventsFor($model);

        return true;
    }

    /**
     * Run after saving a record.
     *
     * @param EloquentModel $model
     */
    public function saved($model)
    {
        $this->dispatchEventsFor($model);
    }

    /**
     * Run before a record is updated.
     *
     * @param EloquentModel $model
     */
    public function updating($model)
    {
        $this->dispatchEventsFor($model);
    }

    /**
     * Run after a record has been updated.
     *
     * @param EloquentModel $model
     */
    public function updated($model)
    {
        $this->dispatchEventsFor($model);

        $model->flushCacheCollection();
    }

    /**
     * Run before deleting a record.
     *
     * @param EloquentModel $model
     */
    public function deleting($model)
    {
        $this->dispatchEventsFor($model);
    }

    /**
     * Run after a record has been deleted.
     *
     * @param EloquentModel $model
     */
    public function deleted($model)
    {
        $this->dispatchEventsFor($model);

        $model->flushCacheCollection();
    }

    /**
     * Run before restoring a record.
     *
     * @param EloquentModel $model
     */
    public function restoring($model)
    {
        $this->dispatchEventsFor($model);
    }

    /**
     * Run after a record has been restored.
     *
     * @param EloquentModel $model
     */
    public function restored($model)
    {
        $this->dispatchEventsFor($model);

        $model->flushCacheCollection();
    }
}
