<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\RollbackStream;
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
     * The stream manager.
     *
     * @var StreamManager
     */
    protected $manager;

    /**
     * Create a new RollbackStreamHandler instance.
     *
     * @param StreamManager $manager
     */
    public function __construct(StreamManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Handle the command.
     *
     * @param RollbackStream $command
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
