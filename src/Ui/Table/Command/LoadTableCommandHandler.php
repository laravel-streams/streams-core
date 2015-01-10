<?php namespace Anomaly\Streams\Platform\Ui\Table\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Command\LoadTableCommand;
use Anomaly\Streams\Platform\Ui\Table\Command\LoadTablePaginationCommand;
use Illuminate\Foundation\Bus\DispatchesCommands;

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

    use DispatchesCommands;

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

        $this->dispatch(new LoadTablePaginationCommand($table));
    }
}
