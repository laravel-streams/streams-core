<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class MigrateAssignments
 *
 * @package Anomaly\Streams\Platform\Database\Migration\Command
 */
class MigrateAssignments
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
     * @var StreamInterface
     */
    protected $stream;

    /**
     * @param Migration       $migration
     * @param array           $fields
     *
     * @param StreamInterface $stream
     */
    public function __construct(Migration $migration, array $fields, StreamInterface $stream = null)
    {
        $this->fields = $fields;
        $this->migration = $migration;
        $this->stream = $stream;
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
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }

}