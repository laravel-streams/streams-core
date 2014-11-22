<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Entry\Command\GenerateEntryModelCommand;
use Anomaly\Streams\Platform\Entry\Command\GenerateEntryTranslationsModelCommand;
use Anomaly\Streams\Platform\Stream\Command\CreateStreamsEntryTableCommand;
use Anomaly\Streams\Platform\Stream\Command\DropStreamsEntryTableCommand;
use Anomaly\Streams\Platform\Stream\Event\StreamCreatedEvent;
use Anomaly\Streams\Platform\Stream\Event\StreamDeletedEvent;
use Anomaly\Streams\Platform\Stream\Event\StreamSavedEvent;
use Anomaly\Streams\Platform\Support\Listener;
use Anomaly\Streams\Platform\Traits\CommandableTrait;

/**
 * Class StreamListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream
 */
class StreamListener extends Listener
{

    use CommandableTrait;

    /**
     * Fire after a stream is saved.
     *
     * @param StreamSavedEvent $event
     */
    public function whenStreamWasSaved(StreamSavedEvent $event)
    {
        $this->generateEntryModels($event->getStream());
    }

    /**
     * Fire after a stream is created.
     *
     * @param StreamCreatedEvent $event
     */
    public function whenStreamWasCreated(StreamCreatedEvent $event)
    {
        $this->createStreamsTable($event->getStream());
        $this->generateEntryModels($event->getStream());
    }

    /**
     * Fire after a stream is deleted.
     *
     * @param StreamDeletedEvent $event
     */
    public function whenStreamWasDeleted(StreamDeletedEvent $event)
    {
        $this->execute(new DropStreamsEntryTableCommand($event->getStream()));
    }

    /**
     * Create the entry table for a stream.
     *
     * @param $stream
     */
    protected function createStreamsTable($stream)
    {
        $this->execute(new CreateStreamsEntryTableCommand($stream));
    }

    /**
     * Generate entry models for the stream.
     *
     * @param StreamModel $stream
     */
    protected function generateEntryModels(StreamModel $stream)
    {
        // Generate the base model.
        $this->execute(new GenerateEntryModelCommand($stream));

        /**
         * If the stream is translatable generate
         * the translations model too.
         */
        if ($stream->isTranslatable()) {

            $this->execute(new GenerateEntryTranslationsModelCommand($stream));
        }
    }
}
 