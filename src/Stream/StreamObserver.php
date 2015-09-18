<?php

namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Stream\Command\CreateStreamsEntryTable;
use Anomaly\Streams\Platform\Stream\Command\DropStreamsEntryTable;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Event\StreamWasCreated;
use Anomaly\Streams\Platform\Stream\Event\StreamWasDeleted;
use Anomaly\Streams\Platform\Stream\Event\StreamWasSaved;
use Anomaly\Streams\Platform\Support\Observer;

/**
 * Class StreamObserver.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream
 */
class StreamObserver extends Observer
{
    /**
     * Run after stream a record.
     *
     * @param StreamInterface $model
     */
    public function saved(StreamInterface $model)
    {
        $model->compile();
        $model->flushCache();

        $this->events->fire(new StreamWasSaved($model));
    }

    /**
     * Run after a stream is created.
     *
     * @param StreamInterface $model
     */
    public function created(StreamInterface $model)
    {
        $model->compile();
        $model->flushCache();

        $this->dispatch(new CreateStreamsEntryTable($model));

        $this->events->fire(new StreamWasCreated($model));
    }

    /**
     * Run after a stream has been deleted.
     *
     * @param StreamInterface $model
     */
    public function deleted(StreamInterface $model)
    {
        $model->compile();
        $model->flushCache();

        $this->dispatch(new DropStreamsEntryTable($model));

        $this->events->fire(new StreamWasDeleted($model));
    }
}
