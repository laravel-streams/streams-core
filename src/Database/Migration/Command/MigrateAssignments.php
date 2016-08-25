<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Database\Migration\Migration;

class MigrateAssignments
{

    /**
     * The migration.
     *
     * @var Migration
     */
    protected $migration;

    /**
     * Create a new MigrateAssignments instance.
     *
     * @param Migration $migration
     */
    public function __construct(Migration $migration)
    {
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
}
