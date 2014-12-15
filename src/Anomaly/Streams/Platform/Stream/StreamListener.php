<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Stream\Event\StreamCreated;
use Anomaly\Streams\Platform\Stream\Event\StreamDeleted;
use Anomaly\Streams\Platform\Stream\Event\StreamSaved;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\EventListener;

/**
 * Class StreamListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream
 */
class StreamListener extends EventListener
{

    use CommanderTrait;

    /**
     * Fire after a stream is saved.
     *
     * @param StreamSaved $event
     */
    public function whenStreamSaved(StreamSaved $event)
    {
        $this->generateEntryModels($event->getStream());
    }

    /**
     * Fire after a stream is created.
     *
     * @param StreamCreated $event
     */
    public function whenStreamCreated(StreamCreated $event)
    {
        $this->createStreamsTable($event->getStream());
        $this->generateEntryModels($event->getStream());
    }

    /**
     * Fire after a stream is deleted.
     *
     * @param StreamDeleted $event
     */
    public function whenStreamDeleted(StreamDeleted $event)
    {
        $stream = $event->getStream();

        $this->execute(
            'Anomaly\Streams\Platform\Stream\Command\DropStreamsEntryTableCommand',
            compact('stream')
        );
    }

    /**
     * Create the entry table for a stream.
     *
     * @param $stream
     */
    protected function createStreamsTable($stream)
    {
        $this->execute(
            'Anomaly\Streams\Platform\Stream\Command\CreateStreamsEntryTableCommand',
            compact('stream')
        );
    }

    /**
     * Generate entry models for the stream.
     *
     * @param StreamModel $stream
     */
    protected function generateEntryModels(StreamModel $stream)
    {
        // Generate the base model.
        $this->execute(
            'Anomaly\Streams\Platform\Entry\Command\GenerateEntryModelCommand',
            compact('stream')
        );

        /**
         * If the stream is translatable generate
         * the translations model too.
         */
        if ($stream->isTranslatable()) {
            $this->execute(
                'Anomaly\Streams\Platform\Entry\Command\GenerateEntryTranslationsModelCommand',
                compact('stream')
            );
        }
    }
}
