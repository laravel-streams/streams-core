<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\Migrate;

/**
 * Class MigrateHandler
 *
 * @package Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class MigrateHandler
{

    /**
     * Migrates fields, streams and assignments migration properties
     *
     * @param Migrate $command
     */
    public function handle(Migrate $command)
    {
        $command->getMigration()->createFields();
        $command->getMigration()->createStream();
        $command->getMigration()->assignFields();
    }

}