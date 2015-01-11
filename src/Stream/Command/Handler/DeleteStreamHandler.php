<?php namespace Anomaly\Streams\Platform\Stream\Command\Handler;

use Anomaly\Streams\Platform\Stream\Command\DeleteStream;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

/**
 * Class DeleteStreamHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream\Command
 */
class DeleteStreamHandler
{

    /**
     * The streams repository.
     *
     * @var \Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface
     */
    protected $streams;

    /**
     * Create a new DeleteStreamHandler instance.
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
     * @param DeleteStream $command
     */
    public function handle(DeleteStream $command)
    {
        return $this->streams->delete($command->getNamespace(), $command->getSlug());
    }
}
