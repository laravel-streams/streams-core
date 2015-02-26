<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\Migrate;

/**
 * Class MigrateHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class MigrateHandler
{

    /**
     * Handle the command.
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
