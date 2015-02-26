<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class MigrateStream
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command
 */
class MigrateStream
{

    /**
     * The migration.
     *
     * @var Migration
     */
    protected $migration;

    /**
     * The stream interface.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new MigrateStream instance.
     *
     * @param Migration       $migration
     * @param StreamInterface $stream
     */
    public function __construct(Migration $migration, StreamInterface $stream = null)
    {
        $this->stream    = $stream;
        $this->migration = $migration;
    }

    /**
     * Get the migration.
     *
     * @return Migration
     */
    public function getMigration()
    {
        return $this->migration;
    }

    /**
     * Get the stream.
     *
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }
}
