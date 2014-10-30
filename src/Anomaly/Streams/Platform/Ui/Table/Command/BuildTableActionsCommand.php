<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

/**
 * Class BuildTableActionsCommand
 *
 * DTO for creating table action configuration.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableActionsCommand
{

    /**
     * The table UI object.
     *
     * @var
     */
    protected $ui;

    /**
     * Create a new BuildTableActionsCommand instance.
     *
     * @param $ui
     */
    function __construct($ui)
    {
        $this->ui = $ui;
    }

    /**
     * Get the UI object.
     *
     * @return mixed
     */
    public function getUi()
    {
        return $this->ui;
    }

}
 