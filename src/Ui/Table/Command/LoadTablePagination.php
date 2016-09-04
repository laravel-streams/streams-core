<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Table\TablePagination;

/**
 * Class LoadTablePagination
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class LoadTablePagination
{

    /**
     * The table object.
     *
     * @var Table
     */
    protected $table;

    /**
     * Create a new LoadTablePagination instance.
     *
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * Handle the command.
     *
     * @param TablePagination $pagination
     */
    public function handle(TablePagination $pagination)
    {
        if ($this->table->getOption('enable_pagination') === false) {
            return;
        }

        $data = $this->table->getData();

        $pagination = $pagination->make($this->table);

        $data->put('pagination', $pagination);
    }
}
