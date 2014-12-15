<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Model\EloquentObserver;
use Anomaly\Streams\Platform\Stream\Event\StreamCreatedEvent;
use Anomaly\Streams\Platform\Stream\Event\StreamDeletedEvent;
use Anomaly\Streams\Platform\Stream\Event\StreamSavedEvent;

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
        app('events')->fire('streams::stream.saved', new StreamSavedEvent($model));

        parent::saved($model);
    }

    /**
     * Run after a stream is created.
     *
     * @param EloquentModel $model
     */
    public function created(EloquentModel $model)
    {
        app('events')->fire('streams::stream.created', new StreamCreatedEvent($model));

        parent::created($model);
    }

    /**
     * Run after a stream has been deleted.
     *
     * @param EloquentModel $model
     */
    public function deleted(EloquentModel $model)
    {
        app('events')->fire('streams::stream.deleted', new StreamDeletedEvent($model));

        parent::deleted($model);
    }
}
