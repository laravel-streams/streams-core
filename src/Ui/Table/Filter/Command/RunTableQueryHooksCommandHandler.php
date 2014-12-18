<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class RunTableQueryHooksCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Filter\Command
 */
class RunTableQueryHooksCommandHandler
{

    /**
     * Apply active table filters.
     *
     * @param RunTableQueryHooksCommand $command
     */
    public function handle(RunTableQueryHooksCommand $command)
    {
        $query   = $command->getQuery();
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $filters = $table->getFilters();

        foreach ($filters->active() as $filter) {
            $this->runTableQueryHook($filter, $builder, $query);
        }
    }

    /**
     * Ryan a filter's query hook.
     *
     * @param FilterInterface $filter
     * @param TableBuilder    $builder
     * @param Builder         $query
     */
    protected function runTableQueryHook(FilterInterface $filter, TableBuilder $builder, Builder $query)
    {
        $filter->onTableQuerying($builder, $query);
    }
}
