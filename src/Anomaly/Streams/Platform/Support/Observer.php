<?php namespace Anomaly\Streams\Platform\Support;

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
     * @param $model
     */
    public function creating($model)
    {
        $this->dispatchEventsFor($model);
    }

    /**
     * Run after a record is created.
     *
     * @param $model
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
     * @param $model
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
     * @param $model
     */
    public function saved($model)
    {
        $this->dispatchEventsFor($model);
    }

    /**
     * Run before a record is updated.
     *
     * @param $model
     */
    public function updating($model)
    {
        $this->dispatchEventsFor($model);
    }

    /**
     * Run after a record has been updated.
     *
     * @param $model
     */
    public function updated($model)
    {
        $this->dispatchEventsFor($model);

        $model->flushCacheCollection();
    }

    /**
     * Run before deleting a record.
     *
     * @param $model
     */
    public function deleting($model)
    {
        $this->dispatchEventsFor($model);
    }

    /**
     * Run after a record has been deleted.
     *
     * @param $model
     */
    public function deleted($model)
    {
        $this->dispatchEventsFor($model);

        $model->flushCacheCollection();
    }

    /**
     * Run before restoring a record.
     *
     * @param $model
     */
    public function restoring($model)
    {
        $this->dispatchEventsFor($model);
    }

    /**
     * Run after a record has been restored.
     *
     * @param $model
     */
    public function restored($model)
    {
        $this->dispatchEventsFor($model);

        $model->flushCacheCollection();
    }
}
 