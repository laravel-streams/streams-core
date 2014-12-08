<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterInterface;

class SetFilterDataCommandHandler
{

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
 