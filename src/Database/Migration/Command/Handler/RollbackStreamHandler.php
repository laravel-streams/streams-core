<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\RollbackStream;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

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
     * Create a new RollbackStreamHandler instance.
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
            $this->streams->delete($stream);
        }

        $this->streams->cleanup();
    }
}
