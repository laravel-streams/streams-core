<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\RollbackStream;
use Anomaly\Streams\Platform\Stream\StreamManager;
use Anomaly\Streams\Platform\Stream\StreamModel;

/**
 * Class RollbackStreamHandler
 *
 * @package Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class RollbackStreamHandler
{
    /**
     * @var StreamManager
     */
    protected $manager;

    /**
     * @param StreamManager $manager
     */
    public function __construct(StreamManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param RollbackStream $command
     *
     * @return mixed
     */
    public function handle(RollbackStream $command)
    {
        $migration = $command->getMigration();

        $stream = $command->getStream() ?: new StreamModel($migration->getStream());

        $namespace = ($stream && $stream->getNamespace()) ? $stream->getNamespace() : $migration->getNamespace();

        $slug = ($stream && $stream->getSlug()) ? $stream->getSlug() :
            array_get($stream->toArray(), 'slug', $migration->getAddonSlug());

        return $this->manager->delete($namespace, $slug);
    }

}