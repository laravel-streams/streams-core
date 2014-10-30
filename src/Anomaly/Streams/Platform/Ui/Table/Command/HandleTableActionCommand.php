<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

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
     * @param $ui
     */
    function __construct($ui)
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
 