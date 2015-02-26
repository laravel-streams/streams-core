<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\Rollback;
use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class RollbackHandler
 *
 * @package Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class RollbackHandler
{

    /**
     * Rollback fields, streams and assignments migration properties
     *
     * @param Rollback $command
     */
    public function handle(Rollback $command)
    {
        $command->getMigration()->unassignFields();
        $command->getMigration()->deleteStream();
        $command->getMigration()->deleteFields();
    }

}