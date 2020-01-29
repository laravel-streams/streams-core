<?php

namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Entry\Command\GenerateEntryModelClassmap;
use Anomaly\Streams\Platform\Search\Command\DeleteEntryIndex;
use Anomaly\Streams\Platform\Stream\Command\CreateStreamsEntryTable;
use Anomaly\Streams\Platform\Stream\Command\DeleteStreamAssignments;
use Anomaly\Streams\Platform\Stream\Command\DeleteStreamEntryModels;
use Anomaly\Streams\Platform\Stream\Command\DropStreamsEntryTable;
use Anomaly\Streams\Platform\Stream\Command\RenameStreamsEntryTable;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Event\StreamWasCreated;
use Anomaly\Streams\Platform\Stream\Event\StreamWasDeleted;
use Anomaly\Streams\Platform\Stream\Event\StreamWasSaved;
use Anomaly\Streams\Platform\Stream\Event\StreamWasUpdated;
use Anomaly\Streams\Platform\Support\Observer;
use Anomaly\Streams\Platform\Version\Contract\VersionRepositoryInterface;

/**
 * Class StreamObserver
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class StreamObserver extends Observer
{

    /**
     * Run before a stream is created.
     *
     * @param StreamInterface $model
     */
    public function creating(StreamInterface $model)
    {
        $model->fireFieldTypeEvents('stream_creating');
    }

    /**
     * Run after a stream is created.
     *
     * @param StreamInterface $model
     */
    public function created(StreamInterface $model)
    {
        dispatch_now(new CreateStreamsEntryTable($model));

        $model->fireFieldTypeEvents('stream_created');

        event(new StreamWasCreated($model));
    }

    /**
     * Run after stream a record.
     *
     * @param StreamInterface $model
     */
    public function saved(StreamInterface $model)
    {
        $model->fireFieldTypeEvents('stream_saved');

        event(new StreamWasSaved($model));
    }

    /**
     * Run before a record is updated.
     *
     * @param StreamInterface $model
     */
    public function updating(StreamInterface $model)
    {
        $model->fireFieldTypeEvents('stream_updating');

        dispatch_now(new RenameStreamsEntryTable($model));
    }

    /**
     * Run after a record is updated.
     *
     * @param StreamInterface $model
     */
    public function updated(StreamInterface $model)
    {
        $model->fireFieldTypeEvents('stream_updated');

        event(new StreamWasUpdated($model));
    }

    /**
     * Run after a stream has been deleted.
     *
     * @param StreamInterface $model
     */
    public function deleted(StreamInterface $model)
    {
        $model->fireFieldTypeEvents('stream_deleted');

        dispatch_now(new DeleteEntryIndex($model));
        dispatch_now(new DropStreamsEntryTable($model));
        dispatch_now(new DeleteStreamEntryModels($model));
        dispatch_now(new DeleteStreamAssignments($model));
        dispatch_now(new GenerateEntryModelClassmap());

        app(VersionRepositoryInterface::class)->deleteVersionHistory($model->getBoundEntryModelName());

        event(new StreamWasDeleted($model));
    }
}
