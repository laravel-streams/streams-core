<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class GetAddonFromMigration
 *
 * @package Anomaly\Streams\Platform\Database\Migration\Command
 */
class GetAddonFromMigration
{
    /**
     * @var Migration
     */
    protected $migration;

    /**
     * @param $migration
     */
    public function __construct(Migration $migration)
    {
        $this->migration = $migration;
    }

    /**
     * @return string
     */
    public function getMigration()
    {
        return $this->migration;
    }

}