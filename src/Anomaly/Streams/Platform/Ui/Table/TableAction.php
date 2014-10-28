<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableActionInterface;

/**
 * Class TableAction
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
     * @var
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
        throw new \Exception("The handle() and authorize() method should be overridden.");
    }

    /**
     * Authorize the user to process the action.
     *
     * @return mixed|void
     * @throws \Exception
     */
    public function authorize()
    {
        throw new \Exception("The handle() and authorize() method should be overridden.");
    }

}
 