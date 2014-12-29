<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

/**
 * Class LoadTableCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class LoadTableCommandHandler
{

    /**
     * Handle the command.
     *
     * @param LoadTableCommand $command
     */
    public function handle(LoadTableCommand $command)
    {
        $table = $command->getTable();

        $data = $table->getData();

        $data->put('table', $table);
    }
}
