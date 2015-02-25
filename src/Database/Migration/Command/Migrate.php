<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;


use Anomaly\Streams\Platform\Database\Migration\Migration;

class Migrate
{
    /**
     * @var Migration
     */
    protected $migration;

    /**
     * @param Migration $migration
     */
    public function __construct(Migration $migration)
    {
        $this->migration = $migration;
    }

    /**
     * @return Migration
     */
    public function getMigration()
    {
        return $this->migration;
    }

}