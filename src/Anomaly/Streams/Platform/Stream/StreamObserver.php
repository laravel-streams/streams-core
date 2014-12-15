<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Model\EloquentObserver;
use Anomaly\Streams\Platform\Stream\Event\StreamCreated;
use Anomaly\Streams\Platform\Stream\Event\StreamDeleted;
use Anomaly\Streams\Platform\Stream\Event\StreamSaved;

/**
 * Class StreamObserver
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream
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
        $model->raise(new StreamSaved($model));

        parent::saved($model);
    }

    /**
     * Run after a stream is created.
     *
     * @param EloquentModel $model
     */
    public function created(EloquentModel $model)
    {
        $model->raise(new StreamCreated($model));

        parent::created($model);
    }

    /**
     * Run after a stream has been deleted.
     *
     * @param EloquentModel $model
     */
    public function deleted(EloquentModel $model)
    {
        $model->raise(new StreamDeleted($model));

        parent::deleted($model);
    }
}
