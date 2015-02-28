<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\RollbackStream;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Anomaly\Streams\Platform\Stream\StreamManager;
use Anomaly\Streams\Platform\Stream\StreamModel;

/**
 * Class RollbackStreamHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class RollbackStreamHandler
{

    /**
     * The stream repository.
     *
     * @var StreamRepositoryInterface
     */
    protected $streams;

    /**
     * The stream manager.
     *
     * @var StreamManager
     */
    protected $manager;

    /**
     * Create a new RollbackStreamHandler instance.
     *
     * @param StreamManager             $manager
     * @param StreamRepositoryInterface $streams
     */
    public function __construct(StreamManager $manager, StreamRepositoryInterface $streams)
    {
        $this->streams = $streams;
        $this->manager = $manager;
    }

    /**
     * Handle the command.
     *
     * @param RollbackStream $command
     */
    public function handle(RollbackStream $command)
    {
        $migration = $command->getMigration();

        $stream    = $command->getStream() ?: new StreamModel($migration->getStream());
        $namespace = ($stream && $stream->getNamespace()) ? $stream->getNamespace() : $migration->getNamespace();

        $slug = ($stream && $stream->getSlug()) ? $stream->getSlug() :
            array_get($stream->toArray(), 'slug', $migration->getAddonSlug());

        if ($stream = $this->streams->findBySlugAndNamespace($slug, $namespace)) {
            $this->manager->delete($stream);
        }
    }
}
