<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableUi;

/**
 * Class HandleTableActionCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTableActionCommand
{

    /**
     * The table UI class.
     *
     * @var
     */
    protected $ui;

    /**
     * Create a new HandleTableActionCommand instance.
     *
     * @param TableUi $ui
     */
    function __construct(TableUi $ui)
    {
        $this->ui = $ui;
    }

    /**
     * Get the table UI class.
     *
     * @return mixed
     */
    public function getUi()
    {
        return $this->ui;
    }

}
 