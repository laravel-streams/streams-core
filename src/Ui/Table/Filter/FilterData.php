<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class FilterData
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Filter
 */
class FilterData
{

    /**
     * Make the filter data.
     *
     * @param TableBuilder $builder
     */
    public function make(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $data  = $table->getData();

        $filters = array_map(
            function (FilterInterface $filter) {
                return $filter->getTableData();
            },
            $table->getFilters()->all()
        );

        $data->put('filters', $filters);
    }
}
