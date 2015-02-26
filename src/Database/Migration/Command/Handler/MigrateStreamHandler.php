<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\MigrateStream;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\StreamManager;

/**
 * Class MigrateStreamHandler
 *
 * @package Anomaly\Streams\Platform\Stream\Command\Handler
 */
class MigrateStreamHandler
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
     * @param MigrateStream $command
     *
     * @return mixed
     */
    public function handle(MigrateStream $command)
    {
        $migration = $command->getMigration();

        $stream = $command->getStream() ?: $migration->getStream();

        if ($stream instanceof StreamInterface) {
            $stream = $stream->toArray();
        }

        $addon = $migration->getAddon();

        $addonSlug = $migration->getAddonSlug();

        $slug = array_get($stream, 'slug', $addonSlug);
        $namespace = array_get($stream, 'namespace', $addonSlug);
        $name = array_get($stream, 'name', $addon ? $addon->getNamespace("stream.{$slug}.name") : null);
        $description = array_get($stream, 'name', $addon ? $addon->getNamespace("stream.{$slug}.description") : null);

        $orderBy = array_get($stream, 'order_by', 'id');
        $titleColumn = array_get($stream, 'title_column', 'id');

        $locked = (array_get($stream, 'locked', false));
        $translatable = (array_get($stream, 'translatable', false));

        $prefix = array_get($stream, 'prefix', $namespace . '_');
        $viewOptions = array_get($stream, 'view_options', ['id', 'created_at']);

        $stream = compact(
            'slug',
            'name',
            'locked',
            'prefix',
            'orderBy',
            'namespace',
            'titleColumn',
            'viewOptions',
            'description',
            'translatable'
        );

        // Create the stream.
        return $this->manager->create($stream);
    }

}