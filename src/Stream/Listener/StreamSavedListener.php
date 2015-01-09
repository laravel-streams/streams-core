<?php namespace Anomaly\Streams\Platform\Stream\Listener;

use Anomaly\Streams\Platform\Entry\EntryUtility;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Event\StreamSavedEvent;

/**
 * Class StreamSavedListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream\Listener
 */
class StreamSavedListener
{

    /**
     * The entry utility.
     *
     * @var EntryUtility
     */
    protected $utility;

    /**
     * Create a new StreamSavedListener instance.
     *
     * @param EntryUtility $utility
     */
    public function __construct(EntryUtility $utility)
    {
        $this->utility = $utility;
    }

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
     * @param StreamInterface $stream
     */
    protected function generateEntryModels(StreamInterface $stream)
    {
        $this->utility->recompile($stream);
    }
}
