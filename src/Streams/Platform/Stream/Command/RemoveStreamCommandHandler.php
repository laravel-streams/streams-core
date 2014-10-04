<?php namespace Streams\Platform\Stream\Command;

use Streams\Platform\Stream\StreamModel;
use Streams\Platform\Traits\DispatchableTrait;
use Streams\Platform\Contract\CommandInterface;

class RemoveStreamCommandHandler implements CommandInterface
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
            $this->dispatchEventsFor($stream);

            return $stream;
        }

        return false;
    }
}
 