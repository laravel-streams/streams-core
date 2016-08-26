<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Illuminate\Cache\CacheManager;
use Anomaly\Streams\Platform\Database\Migration\Migration;

class Rollback
{

    /**
     * The migration.
     *
     * @var Migration
     */
    protected $migration;

    /**
     * Create a new Rollback instance.
     *
     * @param Migration $migration
     */
    public function __construct(Migration $migration)
    {
        $this->migration = $migration;
    }

    /**
     * Handle the command.
     *
     * @param CacheManager $cache
     */
    public function handle(CacheManager $cache)
    {
        $this->migration->unassignFields();
        $this->migration->deleteStream();
        $this->migration->deleteFields();

        $cache->flush();
    }
}
