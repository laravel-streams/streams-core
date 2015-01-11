<?php namespace Anomaly\Streams\Platform\Ui\Table\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Command\LoadTablePagination;
use Anomaly\Streams\Platform\Ui\Table\TablePagination;

/**
 * Class LoadTablePaginationHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class LoadTablePaginationHandler
{

    /**
     * The pagination utility.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\TablePagination
     */
    protected $pagination;

    /**
     * Create a new LoadTablePaginationHandler instance.
     *
     * @param TablePagination $pagination
     */
    public function __construct(TablePagination $pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * Handle the command.
     *
     * @param LoadTablePagination $command
     */
    public function handle(LoadTablePagination $command)
    {
        $table = $command->getTable();

        $data = $table->getData();

        $pagination = $this->pagination->make($table);

        $data->put('pagination', $pagination);
    }
}
