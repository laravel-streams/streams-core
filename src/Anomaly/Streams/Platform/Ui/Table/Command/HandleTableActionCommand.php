<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;

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
     * @var \Anomaly\Streams\Platform\Ui\Table\Table
     */
    protected $ui;

    /**
     * Create a new HandleTableActionCommand instance.
     *
     * @param Table $ui
     */
    function __construct(Table $ui)
    {
        $this->ui = $ui;
    }

    /**
     * Get the table UI class.
     *
     * @return Table
     */
    public function getUi()
    {
        return $this->ui;
    }
}
 