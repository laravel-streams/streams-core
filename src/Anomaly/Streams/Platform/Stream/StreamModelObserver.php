<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Stream\Event\StreamWasCreatedEvent;
use Anomaly\Streams\Platform\Stream\Event\StreamWasDeletedEvent;
use Anomaly\Streams\Platform\Stream\Event\StreamWasSavedEvent;
use Anomaly\Streams\Platform\Support\Observer;

/**
 * Class StreamModelObserver
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream
 */
class StreamModelObserver extends Observer
{

    /**
     * Run after saving a record.
     *
     * @param $model
     */
    public function saved($model)
    {
        $this->dispatch(new StreamWasSavedEvent($model));

        parent::saved($model);
    }

    /**
     * Run after a record is created.
     *
     * @param $model
     */
    public function created($model)
    {
        $this->dispatch(new StreamWasCreatedEvent($model));

        parent::created($model);
    }

    /**
     * Run after a record has been deleted.
     *
     * @param $model
     */
    public function deleted($model)
    {
        $this->dispatch(new StreamWasDeletedEvent($model));

        parent::deleted($model);
    }
}
