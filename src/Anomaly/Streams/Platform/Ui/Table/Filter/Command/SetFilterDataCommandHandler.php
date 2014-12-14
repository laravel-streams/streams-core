<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterInterface;

/**
 * Class SetFilterDataCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Filter\Command
 */
class SetFilterDataCommandHandler
{
    /**
     * Handle the command.
     *
     * @param SetFilterDataCommand $command
     */
    public function handle(SetFilterDataCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();

        $filters = [];

        foreach ($table->getFilters() as $filter) {
            if ($filter instanceof FilterInterface) {
                $filters[] = $filter->viewData();
            }
        }

        $table->putData('filters', $filters);
    }
}
