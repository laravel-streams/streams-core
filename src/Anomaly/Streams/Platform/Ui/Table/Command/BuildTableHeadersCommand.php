<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

/**
 * Class BuildTableHeadersCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableHeadersCommand
{

    /**
     * The table UI object.
     *
     * @var
     */
    protected $ui;

    /**
     * Create a new BuildTableHeadersCommand instance.
     *
     * @param $ui
     */
    function __construct($ui)
    {
        $this->ui = $ui;
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

}
 