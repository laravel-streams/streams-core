<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableActionInterface;

/**
 * Class TableAction
 *
 * This is the default table action class that
 * can be extended or used for reference as long
 * as the TableActionInterface is implemented.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TableAction implements TableActionInterface
{

    /**
     * The table object.
     *
     * @var Table
     */
    protected $table;

    /**
     * Create a new TableAction instance.
     *
     * @param Table $table
     */
    function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * Handle the table action.
     *
     * @param array $ids
     * @return mixed
     */
    public function handle(array $ids)
    {
    }

    /**
     * Authorize the user to process the action.
     *
     * @return mixed|void
     */
    public function authorize()
    {
    }
}
 