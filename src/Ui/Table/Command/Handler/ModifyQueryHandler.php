<?php namespace Anomaly\Streams\Platform\Ui\Table\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Command\ApplyScope;
use Anomaly\Streams\Platform\Ui\Table\Command\ModifyQuery;
use Anomaly\Streams\Platform\Ui\Table\Command\OrderQuery;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\FilterQuery;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Command\TableQuery;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class ModifyQueryHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class ModifyQueryHandler
{

    use DispatchesCommands;

    /**
     * Handle the command.
     *
     * @param ModifyQuery $command
     */
    public function handle(ModifyQuery $command)
    {
        $table = $command->getTable();
        $query = $command->getQuery();

        $this->dispatch(new ApplyScope($table, $query));
        $this->dispatch(new FilterQuery($table, $query));
        $this->dispatch(new TableQuery($table, $query));
        $this->dispatch(new OrderQuery($table, $query));
    }
}
