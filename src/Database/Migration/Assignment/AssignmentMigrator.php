<?php namespace Anomaly\Streams\Platform\Database\Migration\Assignment;

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;

class AssignmentMigrator
{
    /**
     * The field repository.
     *
     * @var AssignmentRepositoryInterface
     */
    protected $fields;

    /**
     * Create a new AssignmentMigrator instance.
     *
     * @param AssignmentRepositoryInterface $fields
     */
    public function __construct(AssignmentRepositoryInterface $fields)
    {
        $this->fields = $fields;
    }

    /**
     * Migrate the migration.
     *
     * @param Migration $migration
     */
    public function migrate(Migration $migration)
    {
        //dd($migration->getAssignments());
    }
}
