<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class SetPaginationDataCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class SetPaginationDataCommandHandler
{

    /**
     * Handle the command.
     *
     * @param SetPaginationDataCommand $command
     */
    public function handle(SetPaginationDataCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();

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

        $table->putData('pagination', $pagination);
    }
}
