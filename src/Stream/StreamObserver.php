<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Model\EloquentObserver;
use Anomaly\Streams\Platform\Stream\Event\StreamWasCreated;
use Anomaly\Streams\Platform\Stream\Event\StreamWasDeleted;
use Anomaly\Streams\Platform\Stream\Event\StreamWasSaved;

/**
 * Class StreamObserver
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream
 */
class StreamObserver extends EloquentObserver
{

    /**
     * Run after stream a record.
     *
     * @param EloquentModel $model
     */
    public function saved(EloquentModel $model)
    {
        $this->dispatcher->fire(new StreamWasSaved($model));

        parent::saved($model);
    }

    /**
     * Run after a stream is created.
     *
     * @param EloquentModel $model
     */
    public function created(EloquentModel $model)
    {
        $this->dispatcher->fire(new StreamWasCreated($model));

        parent::created($model);
    }

    /**
     * Run after a stream has been deleted.
     *
     * @param EloquentModel $model
     */
    public function deleted(EloquentModel $model)
    {
        $this->dispatcher->fire(new StreamWasDeleted($model));

        parent::deleted($model);
    }
}
