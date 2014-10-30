<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableUi;

/**
 * Class BuildTableButtonsCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableButtonsCommand
{

    /**
     * The table UI object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\TableUi
     */
    protected $ui;

    /**
     * The entry payload.
     *
     * @var
     */
    protected $entry;

    /**
     * Create a new BuildTableButtonsCommand instance.
     *
     * @param TableUi $ui
     * @param         $entry
     */
    function __construct(TableUi $ui, $entry)
    {
        $this->ui    = $ui;
        $this->entry = $entry;
    }

    /**
     * Get the table UI object.
     *
     * @return \Anomaly\Streams\Platform\Ui\Table\TableUi
     */
    public function getUi()
    {
        return $this->ui;
    }

    /**
     * Get the entry payload.
     *
     * @return mixed
     */
    public function getEntry()
    {
        return $this->entry;
    }

}
 