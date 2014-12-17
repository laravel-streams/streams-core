<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Class TableData
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TableData
{

    /**
     * Make the table data.
     *
     * @param TableBuilder $builder
     */
    public function make(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $data  = $table->getData();

        $this->makePagination($table, $data);

        $data->put('prefix', $table->getPrefix());
        $data->put('sortable', $table->isSortable());
        $data->put('filtering', ($table->getFilters()->active()->count()));
        $data->put('noResultsMessage', trans($table->getNoResultsMessage()));
    }

    /**
     * Make the pagination data.
     *
     * @param TableBuilder $builder
     */
    protected function makePagination(Table $table, Collection $data)
    {
        $perPage   = $table->getLimit();
        $page      = app('request')->get('page');
        $path      = '/' . app('request')->path();
        $paginator = new LengthAwarePaginator(
            $table->getEntries(),
            $table->getTotal(),
            $perPage,
            $page,
            compact('path')
        );

        $pagination          = $paginator->toArray();
        $pagination['links'] = $paginator->appends($_GET)->render();

        $data->put('pagination', $pagination);
    }
}
