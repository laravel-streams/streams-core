<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Entry\Command\GenerateEntryModelCommand;
use Anomaly\Streams\Platform\Entry\Command\GenerateEntryTranslationsModelCommand;
use Anomaly\Streams\Platform\Stream\Command\CreateStreamsEntryTableCommand;
use Anomaly\Streams\Platform\Stream\Event\StreamWasCreatedEvent;
use Anomaly\Streams\Platform\Stream\Event\StreamWasDeletedEvent;
use Anomaly\Streams\Platform\Stream\Event\StreamWasSavedEvent;
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
     * @param StreamWasSavedEvent $event
     */
    public function whenStreamWasSaved(StreamWasSavedEvent $event)
    {
        $this->generateEntryModels($event->getStream());
    }

    /**
     * Fire after a stream is created.
     *
     * @param StreamWasCreatedEvent $event
     */
    public function whenStreamWasCreated(StreamWasCreatedEvent $event)
    {
        $this->createStreamsTable($event->getStream());
        $this->generateEntryModels($event->getStream());
    }

    /**
     * Fire after a stream is deleted.
     *
     * @param StreamWasDeletedEvent $event
     */
    public function whenStreamWasDeleted(StreamWasDeletedEvent $event)
    {
        //
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
 