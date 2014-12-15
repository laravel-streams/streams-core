<?php namespace Anomaly\Streams\Platform\Stream\Listener;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Event\StreamCreatedEvent;
use Anomaly\Streams\Platform\Stream\StreamModel;
use Laracasts\Commander\CommanderTrait;

/**
 * Class StreamCreatedListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Listener
 */
class StreamCreatedListener
{

    use CommanderTrait;

    /**
     * When a stream is created we have some
     * generation to do. Create the streams
     * table as well as the entry models.
     *
     * @param StreamCreatedEvent $event
     */
    public function handle(StreamCreatedEvent $event)
    {
        $this->createStreamsTable($event->getStream());
        $this->generateEntryModels($event->getStream());
    }

    /**
     * Create the entry table for a stream.
     *
     * @param StreamInterface $stream
     */
    protected function createStreamsTable(StreamInterface $stream)
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
