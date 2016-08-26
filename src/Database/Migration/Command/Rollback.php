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
     * @param CacheManager       $cache
     * @param FieldMigrator      $fields
     * @param StreamMigrator     $streams
     * @param AssignmentMigrator $assignments
     */
    public function handle(
        CacheManager $cache,
        FieldMigrator $fields,
        StreamMigrator $streams,
        AssignmentMigrator $assignments
    ) {
        $assignments->rollback($this->migration);
        $fields->rollback($this->migration);
        $streams->rollback($this->migration);

        $cache->flush();
    }
}
