<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\MigrateStream;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\StreamManager;

/**
 * Class MigrateStreamHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class MigrateStreamHandler
{

    /**
     * The stream manager.
     *
     * @var StreamManager
     */
    protected $manager;

    /**
     * Create a new MigrateStreamHandler instance.
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
     * @param MigrateStream $command
     * @return null|StreamInterface
     */
    public function handle(MigrateStream $command)
    {
        $migration = $command->getMigration();
        $stream    = $command->getStream() ?: $migration->getStream();

        if ($stream instanceof StreamInterface) {
            $stream = $stream->toArray();
        }

        if (is_string($stream)) {
            $stream = [
                'slug' => $stream
            ];
        }

        if (!$stream) {
            return;
        }

        $addon     = $migration->getAddon();
        $addonSlug = $migration->getAddonSlug();

        $stream['slug']      = array_get($stream, 'slug', $addonSlug);
        $stream['namespace'] = array_get($stream, 'namespace', $addonSlug);

        $stream['name'] = array_get(
            $stream,
            'name',
            $addon ? $addon->getNamespace("stream.{$stream['slug']}.name") : null
        );

        $stream['description'] = array_get(
            $stream,
            'name',
            $addon ? $addon->getNamespace("stream.{$stream['slug']}.description") : null
        );

        // Create the stream.
        return $this->manager->create($stream);
    }
}
