<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class LoadPaginationDataCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class LoadPaginationDataCommandHandler
{

    /**
     * Put view data for pagination.
     *
     * @param LoadPaginationDataCommand $command
     */
    public function handle(LoadPaginationDataCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $data    = $table->getData();

        $perPage = $table->getLimit();
        $page    = app('request')->get('page');
        $path    = '/' . app('request')->path();

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
