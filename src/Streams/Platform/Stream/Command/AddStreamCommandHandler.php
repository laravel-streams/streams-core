<?php namespace Streams\Platform\Stream\Command;

use Streams\Platform\Stream\StreamModel;
use Streams\Platform\Traits\DispatchableTrait;
use Streams\Platform\Contract\CommandInterface;

class AddStreamCommandHandler implements CommandInterface
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
        $stream = $this->stream->findByNamespaceAndSlug($command->getNamespace(), $command->getSlug());

        if ($stream) {
            throw new \Exception(
                "The stream is already installed [{$command->getNamespace()}, {$command->getSlug()}]."
            );
        }

        $stream = $this->stream->add(
            $command->getNamespace(),
            $command->getSlug(),
            $command->getPrefix(),
            $command->getName(),
            $command->getDescription(),
            $command->getViewOptions(),
            $command->getTitleColumn(),
            $command->getOrderBy(),
            $command->getIsHidden(),
            $command->getIsTranslatable(),
            $command->getIsRevisionable()
        );

        $this->dispatchEventsFor($stream);

        return $stream;
    }
}
 