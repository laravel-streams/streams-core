<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class MigrateFields
 *
 * @package Anomaly\Streams\Platform\Database\Migration\Command
 */
class MigrateFields
{

    /**
     * @var Migration
     */
    protected $migration;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @var string|null
     */
    protected $namespace;
    
    /**
     * @param Migration $migration
     * @param array     $fields
     * @param null      $namespace
     *
     */
    public function __construct(Migration $migration, array $fields, $namespace = null)
    {
        $this->fields = $fields;
        $this->namespace = $namespace;
        $this->migration = $migration;
    }

    /**
     * @return Migration
     */
    public function getMigration()
    {
        return $this->migration;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return string|null
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

}