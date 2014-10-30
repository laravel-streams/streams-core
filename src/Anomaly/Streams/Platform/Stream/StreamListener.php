<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Entry\Command\GenerateEntryModelCommand;
use Anomaly\Streams\Platform\Stream\Command\CreateStreamsEntryTableCommand;
use Anomaly\Streams\Platform\Stream\Event\StreamWasCreatedEvent;
use Anomaly\Streams\Platform\Stream\Event\StreamWasDeletedEvent;
use Anomaly\Streams\Platform\Stream\Event\StreamWasSavedEvent;
use Anomaly\Streams\Platform\Support\Listener;
use Anomaly\Streams\Platform\Traits\CommandableTrait;

class StreamListener extends Listener
{

    use CommandableTrait;

    public function whenStreamWasSaved(StreamWasSavedEvent $event)
    {
        $command = new GenerateEntryModelCommand($event->getStream());

        $this->execute($command);
    }

    public function whenStreamWasCreated(StreamWasCreatedEvent $event)
    {
        $command = new CreateStreamsEntryTableCommand($event->getStream());

        $this->execute($command);
    }

    public function whenStreamWasDeleted(StreamWasDeletedEvent $event)
    {
        //
    }
}
 