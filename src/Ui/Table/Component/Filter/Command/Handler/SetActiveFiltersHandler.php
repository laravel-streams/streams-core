<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\SetActiveFilters;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;

/**
 * Class SetActiveFiltersHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command
 */
class SetActiveFiltersHandler
{

    /**
     * Set active filters.
     *
     * @param SetActiveFilters $command
     */
    public function handle(SetActiveFilters $command)
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
