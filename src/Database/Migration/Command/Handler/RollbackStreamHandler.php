<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\RollbackStream;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Anomaly\Streams\Platform\Stream\StreamManager;

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

        $stream = $migration->getStream();

        if (!$stream) {
            return;
        }

        if (is_string($stream)) {
            $stream = [
                'slug' => $stream
            ];
        }

        $addon = $migration->getAddon();

        $stream['slug']      = array_get($stream, 'slug', $addon ? $addon->getSlug() : null);
        $stream['namespace'] = array_get($stream, 'namespace', $addon ? $addon->getSlug() : null);

        if ($stream = $this->streams->findBySlugAndNamespace($stream['slug'], $stream['namespace'])) {
            $this->manager->delete($stream);
        }

        $this->streams->deleteGarbage();
    }
}
