<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class BuildTableFiltersCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableFiltersCommand
{

    /**
     * The table UI object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Table
     */
    protected $ui;

    /**
     * Create a new BuildTableFiltersCommand instance.
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
     * @return Table
     */
    public function getUi()
    {
        return $this->ui;
    }
}
 