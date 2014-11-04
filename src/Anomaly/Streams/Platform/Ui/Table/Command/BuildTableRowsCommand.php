<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class BuildTableRowsCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableRowsCommand
{

    /**
     * The table UI object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Table
     */
    protected $ui;

    /**
     * Create a new BuildTableRowsCommand instance.
     *
     * @param Table $ui
     */
    function __construct(Table $ui)
    {
        $this->ui = $ui;
    }

    /**
     * Get the table UI object.
     *
     * @return \Anomaly\Streams\Platform\Ui\Table\Table
     */
    public function getUi()
    {
        return $this->ui;
    }
}
 