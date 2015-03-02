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
     * @return StreamInterface
     */
    public function handle(MigrateStream $command)
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
                $addon ? $addon->getNamespace("stream.{$stream['slug']}.description") : null
            );
        }

        // Create the stream.
        return $this->manager->create($stream);
    }
}
