<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterHandlerInterface;

/**
 * Class RunTableQueryHooksCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command
 */
class RunTableQueryHooksCommandHandler
{

    /**
     * Handle the command.
     *
     * @param RunTableQueryHooksCommand $command
     */
    public function handle(RunTableQueryHooksCommand $command)
    {
        $event = $command->getEvent();

        $table   = $event->getTable();
        $filters = $table->getFilters();

        foreach ($filters->active() as $filter) {
            if ($filter instanceof FilterHandlerInterface) {
                $filter->onTableQuery($command->getEvent());
            }
        }
    }
}
