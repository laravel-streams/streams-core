<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\FilterQueryCommand;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Command\TableQueryCommand;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class ModifyQueryCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class ModifyQueryCommandHandler
{

    use DispatchesCommands;

    /**
     * Handle the command.
     *
     * @param ModifyQueryCommand $command
     */
    public function handle(ModifyQueryCommand $command)
    {
        $table = $command->getTable();
        $query = $command->getQuery();

        $this->dispatch(new FilterQueryCommand($table, $query));
        $this->dispatch(new TableQueryCommand($table, $query));
        $this->dispatch(new OrderQueryCommand($table, $query));
    }
}
