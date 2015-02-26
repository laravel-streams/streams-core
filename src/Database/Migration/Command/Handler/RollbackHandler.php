<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\Rollback;

/**
 * Class RollbackHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class RollbackHandler
{

    /**
     * Handle the command.
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
