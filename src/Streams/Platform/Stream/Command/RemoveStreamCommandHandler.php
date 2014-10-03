<?php namespace Streams\Platform\Stream\Command;

use Laracasts\Commander\CommandHandler;
use Streams\Platform\Stream\StreamModel;
use Streams\Platform\Traits\DispatchableTrait;

class RemoveStreamCommandHandler implements CommandHandler
{
    use DispatchableTrait;

    /**
     * The stream model.
     *
     * @var \Streams\Platform\Stream\StreamModel
     */
    protected $stream;

    /**
     * Create a new InstallStreamCommandHandler instance.
     *
     * @param StreamModel $stream
     */
    function __construct(StreamModel $stream)
    {
        $this->stream = $stream;
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
            $this->dispatchEventsFor($stream->releaseEvents());

            return $stream;
        }

        return false;
    }
}
 