<?php namespace Anomaly\Streams\Platform\Ui\Table\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Command\LoadTable;
use Anomaly\Streams\Platform\Ui\Table\Command\LoadTablePagination;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class LoadTableHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class LoadTableHandler
{

    use DispatchesCommands;

    /**
     * Handle the command.
     *
     * @param LoadTable $command
     */
    public function handle(LoadTable $command)
    {
        $table = $command->getTable();

        $table->addData('table', $table);

        $this->dispatch(new LoadTablePagination($table));
    }
}
