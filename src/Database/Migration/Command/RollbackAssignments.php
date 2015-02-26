<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class RollbackAssignments
 *
 * @package Anomaly\Streams\Platform\Database\Migration\Command
 */
class RollbackAssignments
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
     * @var array
     */

    protected $stream;

    /**
     * @param Migration       $migration
     * @param array           $fields
     * @param StreamInterface $stream
     */
    public function __construct(Migration $migration, array $fields = [], StreamInterface $stream = null)
    {
        $this->migration = $migration;
        $this->fields = $fields;
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