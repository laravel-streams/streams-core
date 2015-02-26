<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class RollbackFields
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command
 */
class RollbackFields
{

    /**
     * The migration.
     *
     * @var Migration
     */
    protected $migration;

    /**
     * The fields to rollback.
     *
     * @var array
     */
    protected $fields;

    /**
     * The namespace.
     *
     * @var string|null
     */
    protected $namespace;

    /**
     * Create a new RollbackFields instnace.
     *
     * @param Migration   $migration
     * @param array       $fields
     * @param string|null $namespace
     */
    public function __construct(Migration $migration, array $fields, $namespace = null)
    {
        $this->fields    = $fields;
        $this->migration = $migration;
        $this->namespace = $namespace;
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
     * Get the fields.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Get the namespace.
     *
     * @return string|null
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
}
