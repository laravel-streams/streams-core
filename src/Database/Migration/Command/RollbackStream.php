<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

class RollbackStream
{

    /**
     * The migration.
     *
     * @var Migration
     */
    protected $migration;

    /**
     * Create a new RollbackStream instance.
     *
     * @param Migration       $migration
     * @param StreamInterface $stream
     *
     */
    public function __construct(Migration $migration, StreamInterface $stream = null)
    {
        $this->stream    = $stream;
        $this->migration = $migration;
    }

    /**
     * Handle the command.
     *
     * @param StreamRepositoryInterface $streams
     */
    public function handle(StreamRepositoryInterface $streams)
    {
        if (!$this->stream) {
            return;
        }

        if (is_string($this->stream)) {
            $stream = [
                'slug' => $this->stream,
            ];
        }

        $addon = $this->migration->getAddon();

        $stream['slug']      = array_get($stream, 'slug', $addon ? $addon->getSlug() : null);
        $stream['namespace'] = array_get($stream, 'namespace', $addon ? $addon->getSlug() : null);

        if ($stream = $streams->findBySlugAndNamespace($stream['slug'], $stream['namespace'])) {
            $streams->delete($stream);
        }
    }
}
