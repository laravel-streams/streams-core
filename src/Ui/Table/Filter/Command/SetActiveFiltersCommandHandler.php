<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class SetActiveFiltersCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Filter\Command
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
            $this->setActiveFromRequest($table, $filter);
        }
    }

    /**
     * Set the filter as active based on the request.
     *
     * @param Table           $table
     * @param FilterInterface $filter
     */
    protected function setActiveFromRequest(Table $table, FilterInterface $filter)
    {
        if (app('request')->get($table->getPrefix() . $filter->getSlug() . '_filter')) {
            $filter->setActive(true);
        }
    }
}
