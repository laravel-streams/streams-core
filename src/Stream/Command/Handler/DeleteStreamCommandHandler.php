<?php namespace Anomaly\Streams\Platform\Stream\Command\Handler;

use Anomaly\Streams\Platform\Stream\Command\DeleteStreamCommand;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

/**
 * Class DeleteStreamCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream\Command
 */
class DeleteStreamCommandHandler
{

    /**
     * The streams repository.
     *
     * @var \Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface
     */
    protected $streams;

    /**
     * Create a new DeleteStreamCommandHandler instance.
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
     * @param DeleteStreamCommand $command
     */
    public function handle(DeleteStreamCommand $command)
    {
        return $this->streams->delete($command->getNamespace(), $command->getSlug());
    }
}
