<?php namespace Anomaly\Streams\Platform\Stream\Command\Handler;

use Anomaly\Streams\Platform\Stream\Command\CreateStream;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

/**
 * Class CreateStreamHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream\Command
 */
class CreateStreamHandler
{

    /**
     * The schema object.
     *
     * @var \Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface
     */
    protected $streams;

    /**
     * Create a new CreateStreamHandler instance.
     *
     * @param StreamRepositoryInterface $streams
     */
    public function __construct(StreamRepositoryInterface $streams)
    {
        $this->streams = $streams;
    }

    /**
     * Handle the command.
     *
     * @param  CreateStream $command
     * @return \Anomaly\Streams\Platform\Stream\Contract\StreamInterface
     */
    public function handle(CreateStream $command)
    {
        return $this->streams->create(
            $command->getNamespace(),
            $command->getSlug(),
            $command->getName(),
            $command->getPrefix(),
            $command->getDescription(),
            $command->getViewOptions(),
            $command->getTitleColumn(),
            $command->getOrderBy(),
            $command->isLocked(),
            $command->isTranslatable()
        );
    }
}
