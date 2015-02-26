<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class MigrateFields
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command
 */
class MigrateFields
{

    /**
     * The fields definitions.
     *
     * @var array
     */
    protected $fields;

    /**
     * The migration.
     *
     * @var Migration
     */
    protected $migration;

    /**
     * The namespace.
     *
     * @var string|null
     */
    protected $namespace;

    /**
     * Create a new MigrateFields instance.
     *
     * @param Migration $migration
     * @param array     $fields
     * @param null      $namespace
     *
     */
    public function __construct(Migration $migration, array $fields, $namespace = null)
    {
        $this->fields    = $fields;
        $this->namespace = $namespace;
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
     * Get the namespace.
     *
     * @return string|null
     */
    public function getNamespace()
    {
        return $this->namespace;
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
}
