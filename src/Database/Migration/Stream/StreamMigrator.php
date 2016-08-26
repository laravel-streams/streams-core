<?php namespace Anomaly\Streams\Platform\Database\Migration\Stream;

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

class StreamMigrator
{
    /**
     * The stream repository.
     *
     * @var StreamRepositoryInterface
     */
    protected $streams;

    /**
     * Create a new StreamMigrator instance.
     *
     * @param StreamRepositoryInterface $streams
     */
    public function __construct(StreamRepositoryInterface $streams)
    {
        $this->streams = $streams;
    }

    /**
     * Migrate the migration.
     *
     * @param Migration $migration
     */
    public function migrate(Migration $migration)
    {
        //dd($migration->getStream());
    }
}
