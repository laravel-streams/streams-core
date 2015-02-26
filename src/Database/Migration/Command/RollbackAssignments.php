<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class RollbackAssignments
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command
 */
class RollbackAssignments
{

    /**
     * The migratoin.
     *
     * @var Migration
     */
    protected $migration;

    /**
     * The fields to rollback
     * assignments of.
     *
     * @var array
     */
    protected $fields;

    /**
     * The stream interface.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new RollbackAssignments instance.
     *
     * @param Migration       $migration
     * @param array           $fields
     * @param StreamInterface $stream
     */
    public function __construct(Migration $migration, array $fields = [], StreamInterface $stream = null)
    {
        $this->fields    = $fields;
        $this->stream    = $stream;
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
     * Get the fields.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Get the stream.
     *
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }
}
