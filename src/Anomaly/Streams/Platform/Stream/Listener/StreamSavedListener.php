<?php namespace Anomaly\Streams\Platform\Stream\Listener;

use Anomaly\Streams\Platform\Stream\Event\StreamSavedEvent;
use Anomaly\Streams\Platform\Stream\StreamModel;
use Laracasts\Commander\CommanderTrait;

/**
 * Class StreamSavedListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Listener
 */
class StreamSavedListener
{

    use CommanderTrait;

    /**
     * When a stream is saved we need to
     * regenerate it's entry models.
     *
     * @param StreamSavedEvent $event
     */
    public function handle(StreamSavedEvent $event)
    {
        $this->generateEntryModels($event->getStream());
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
