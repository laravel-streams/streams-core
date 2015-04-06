<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Table\TablePagination;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class LoadTablePagination
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class LoadTablePagination implements SelfHandling
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
        $data = $this->table->getData();

        $pagination = $pagination->make($this->table);

        $data->put('pagination', $pagination);
    }
}
