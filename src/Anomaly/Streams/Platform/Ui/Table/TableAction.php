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
     * The table UI class.
     *
     * @var TableUi
     */
    protected $ui;

    /**
     * Create a new TableAction instance.
     *
     * @param TableUi $ui
     */
    function __construct(TableUi $ui)
    {
        $this->ui = $ui;
    }

    /**
     * Handle the table action.
     *
     * @return mixed|void
     * @throws \Exception
     */
    public function handle()
    {
        //
    }

    /**
     * Authorize the user to process the action.
     *
     * @return mixed|void
     * @throws \Exception
     */
    public function authorize()
    {
        //
    }
}
 