<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class RollbackStream
 *
 * @package Anomaly\Streams\Platform\Database\Migration\Command
 */
class RollbackStream
{
    /**
     * @var Migration
     */
    protected $migration;

    /**
     * @var StreamInterface
     */
    protected $stream;

    /**
     * @param Migration       $migration
     * @param StreamInterface $stream
     *
     */
    public function __construct(Migration $migration, StreamInterface $stream = null)
    {
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
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }

}