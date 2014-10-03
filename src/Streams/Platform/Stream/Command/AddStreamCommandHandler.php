<?php namespace Streams\Platform\Stream\Command;

use Laracasts\Commander\CommandHandler;
use Streams\Platform\Stream\StreamModel;
use Laracasts\Commander\Events\EventDispatcher;

class AddStreamCommandHandler implements CommandHandler
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

        $this->dispatcher->dispatch($stream->releaseEvents());

        return $stream;
    }
}
 