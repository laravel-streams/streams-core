<?php

namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class TablePagination.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TablePagination
{
    /**
     * Return table pagination data.
     *
     * @param Table $table
     * @return array
     */
    public function make(Table $table)
    {
        $options = $table->getOptions();

        $perPage   = $options->get('limit', 15);
        $page      = app('request')->get('page');
        $path      = '/'.app('request')->path();
        $paginator = new LengthAwarePaginator(
            $table->getEntries(),
            $options->get('total_results', 0),
            $perPage,
            $page,
            compact('path')
        );

        $pagination          = $paginator->toArray();
        $pagination['links'] = $paginator->appends(app('request')->all())->render();

        return $pagination;
    }
}
