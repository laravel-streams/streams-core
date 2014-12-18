<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ApplyTableFiltersCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Filter\Command
 */
class ApplyTableFiltersCommandHandler
{

    /**
     * Apply active table filters.
     *
     * @param ApplyTableFiltersCommand $command
     */
    public function handle(ApplyTableFiltersCommand $command)
    {
        $query   = $command->getQuery();
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $filters = $table->getFilters();

        foreach ($filters->active() as $filter) {
            $this->runQueryHook($filter, $builder, $query);
        }
    }

    /**
     * Ryan a filter's query hook.
     *
     * @param FilterInterface $filter
     * @param TableBuilder    $builder
     * @param Builder         $query
     */
    protected function runQueryHook(FilterInterface $filter, TableBuilder $builder, Builder $query)
    {
        $filter->onTableQuerying($builder, $query);
    }
}
