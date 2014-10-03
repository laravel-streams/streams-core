<?php namespace Streams\Platform\Stream\Command;

use Laracasts\Commander\CommandHandler;
use Streams\Platform\Stream\StreamModel;
use Laracasts\Commander\Events\EventDispatcher;

class RemoveStreamCommandHandler implements CommandHandler
{
    /**
     * The event dispatcher.
     *
     * @var \Laracasts\Commander\Events\EventDispatcher
     */
    protected $dispatcher;

    /**
     * The stream model.
     *
     * @var \Streams\Platform\Stream\StreamModel
     */
    protected $stream;

    /**
     * Create a new InstallStreamCommandHandler instance.
     *
     * @param EventDispatcher $dispatcher
     * @param StreamModel     $stream
     */
    function __construct(EventDispatcher $dispatcher, StreamModel $stream)
    {
        $this->stream     = $stream;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle the command.
     *
     * @param $command
     * @return $this|mixed
     */
    public function handle($command)
    {
        $stream = $this->stream->remove(
            $command->getNamespace(),
            $command->getSlug()
        );

        if ($stream) {
            $this->dispatcher->dispatch($stream->releaseEvents());

            return $stream;
        }

        return false;
    }
}
 