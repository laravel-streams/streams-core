<?php namespace Anomaly\Streams\Platform\Stream\Listener;

use Anomaly\Streams\Platform\Entry\EntryUtility;
use Anomaly\Streams\Platform\Stream\Command\CreateStreamsEntryTableCommand;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Event\StreamCreatedEvent;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class StreamCreatedListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream\Listener
 */
class StreamCreatedListener
{

    use DispatchesCommands;

    /**
     * The entry utility.
     *
     * @var \Anomaly\Streams\Platform\Entry\EntryUtility
     */
    protected $utility;

    /**
     * Create a new StreamCreatedListener instance.
     *
     * @param EntryUtility $utility
     */
    public function __construct(EntryUtility $utility)
    {
        $this->utility = $utility;
    }

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
        $this->dispatch(new CreateStreamsEntryTableCommand($stream));
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
