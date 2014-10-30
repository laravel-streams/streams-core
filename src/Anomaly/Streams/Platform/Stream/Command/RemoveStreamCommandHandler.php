<?php namespace Anomaly\Streams\Platform\Stream\Command;

use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;

class RemoveStreamCommandHandler
{

    use DispatchableTrait;

    /**
     * The stream model.
     *
     * @var \Anomaly\Streams\Platform\Stream\StreamModel
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
    public function handle(RemoveStreamCommand $command)
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
 