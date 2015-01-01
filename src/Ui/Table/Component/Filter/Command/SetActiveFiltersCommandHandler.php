<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;

/**
 * Class SetActiveFiltersCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command
 */
class SetActiveFiltersCommandHandler
{

    /**
     * Set active filters.
     *
     * @param SetActiveFiltersCommand $command
     */
    public function handle(SetActiveFiltersCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();

        foreach ($table->getFilters() as $filter) {
            if ($filter instanceof FilterInterface) {
                if (app('request')->get($filter->getFieldName())) {
                    $filter->setActive(true);
                }
            }
        }
    }
}
