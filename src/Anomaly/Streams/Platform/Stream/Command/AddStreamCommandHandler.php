<?php namespace Anomaly\Streams\Platform\Stream\Command;

use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;

class AddStreamCommandHandler
{

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
    public function handle(AddStreamCommand $command)
    {
        $stream = $this->stream->findByNamespaceAndSlug($command->getNamespace(), $command->getSlug());

        if ($stream) {
            throw new \Exception(
                "The stream is already installed [{$command->getNamespace()}, {$command->getSlug()}]."
            );
        }

        return $this->stream->add(
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
    }
}
 