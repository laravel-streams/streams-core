<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Stream\Event\StreamWasDeletedEvent;
use Anomaly\Streams\Platform\Support\Listener;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Stream\Event\StreamWasCreatedEvent;
use Anomaly\Streams\Platform\Stream\Command\CreateStreamsEntryTableCommand;
use Anomaly\Streams\Platform\Stream\Command\CreateStreamsEntryTranslationsTableCommand;

class StreamListener extends Listener
{
    use CommandableTrait;

    public function whenStreamWasCreated(StreamWasCreatedEvent $event)
    {
        $stream = $event->getStream();

        $table = $stream->getEntryTableName();

        $command = new CreateStreamsEntryTableCommand($table);

        $this->execute($command);

        if ($stream->is_translatable) {

            $table = $stream->getEntryTranslationsTableName();

            $command = new CreateStreamsEntryTranslationsTableCommand($table);

            $this->execute($command);

        }
    }

    public function whenStreamWasDeleted(StreamWasDeletedEvent $event)
    {
        //
    }
}
 