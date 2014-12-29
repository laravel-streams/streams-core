<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

/**
 * Class LoadTableEntriesCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class LoadTableEntriesCommandHandler
{

    /**
     * Handle the command.
     *
     * @param LoadTableEntriesCommand $command
     */
    public function handle(LoadTableEntriesCommand $command)
    {
        $table = $command->getTable();

        $entries = $table->getEntries();
        $data    = $table->getData();

        $data->put('entries', $entries);
    }
}
