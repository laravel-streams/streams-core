<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

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
     * @var
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
     * @param $ui
     * @param $entry
     */
    function __construct($ui, $entry)
    {
        $this->ui    = $ui;
        $this->entry = $entry;
    }

    /**
     * Get the table UI object.
     *
     * @return mixed
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
 