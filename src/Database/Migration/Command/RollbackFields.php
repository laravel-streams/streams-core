<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class RollbackFields
 *
 * @package Anomaly\Streams\Platform\Database\Migration\Command
 */
class RollbackFields
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
     * @param Migration   $migration
     * @param array       $fields
     * @param string|null $namespace
     */
    public function __construct(Migration $migration, array $fields, $namespace = null)
    {
        $this->migration = $migration;
        $this->fields = $fields;
        $this->namespace = $namespace;
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