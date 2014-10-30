<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Model\EloquentObserver;
use Anomaly\Streams\Platform\Stream\Event\StreamWasCreatedEvent;
use Anomaly\Streams\Platform\Stream\Event\StreamWasDeletedEvent;
use Anomaly\Streams\Platform\Stream\Event\StreamWasSavedEvent;

class StreamObserver extends EloquentObserver
{

    /**
     * Run before attempting to save a record.
     *
     * @param $model
     * @return bool
     */
    public function saving($model)
    {
        return parent::saving($model);
    }

    /**
     * Run after saving a record.
     *
     * @param $model
     */
    public function saved($model)
    {
        $model->raise(new StreamWasSavedEvent($model));

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
        $model->raise(new StreamWasCreatedEvent($model));

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
        $model->raise(new StreamWasDeletedEvent($model));

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
