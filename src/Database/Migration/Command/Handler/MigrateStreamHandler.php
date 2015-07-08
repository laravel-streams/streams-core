<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\MigrateStream;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

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
     * The stream repository.
     *
     * @var StreamRepositoryInterface
     */
    protected $streams;

    /**
     * Create a new MigrateStreamHandler instance.
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
     * @param MigrateStream $command
     * @return StreamInterface
     */
    public function handle(MigrateStream $command)
    {
        $migration = $command->getMigration();

        $stream = $migration->getStream();

        if (!$stream) {
            return null;
        }

        if (is_string($stream)) {
            $stream = [
                'slug' => $stream
            ];
        }

        $addon = $migration->getAddon();

        $stream['slug']      = array_get($stream, 'slug', $addon ? $addon->getSlug() : null);
        $stream['namespace'] = array_get($stream, 'namespace', $addon ? $addon->getSlug() : null);

        if ($this->streams->findBySlugAndNamespace($stream['slug'], $stream['namespace'])) {
            return null;
        }

        /**
         * If the name exists in the base array
         * then move it to the translated array
         * for the default locale.
         */
        if ($name = array_pull($stream, 'name')) {
            $stream = array_add($stream, config('app.fallback_locale') . '.name', $name);
        }

        /**
         * If the name is not set then make one
         * based on a standardized pattern.
         */
        if (!array_get($stream, config('app.fallback_locale') . '.name')) {
            $stream = array_add(
                $stream,
                config('app.fallback_locale') . '.name',
                $addon ? $addon->getNamespace("stream.{$stream['slug']}.name") : null
            );
        }

        /**
         * If the description exists in the base array
         * then move it to the translated array
         * for the default locale.
         */
        if ($description = array_pull($stream, 'description')) {
            $stream = array_add($stream, config('app.fallback_locale') . '.description', $description);
        }

        /**
         * If the name is not set then make one
         * based on a standardized pattern.
         */
        if (!array_get($stream, config('app.fallback_locale') . '.description')) {
            $stream = array_add(
                $stream,
                config('app.fallback_locale') . '.description',
                $addon ? $addon->getNamespace("stream.{$stream['slug']}.description") : 'foo'
            );
        }

        // Create the stream.
        return $this->streams->create($stream);
    }
}
