<?php namespace Anomaly\Streams\Platform\Ui\Table\Event;

use Anomaly\Streams\Platform\Ui\Table\TableUi;

/**
 * Class RenderingTableEvent
 * Fired just before rendering the table UI.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Event
 */
class RenderingTableEvent
{

    /**
     * The table UI class.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\TableUi
     */
    protected $ui;

    /**
     * The view data array.
     *
     * @var
     */
    protected $data;

    /**
     * Create a new RenderingTableEvent instance.
     *
     * @param $ui
     * @param $data
     */
    function __construct(TableUi $ui, $data)
    {
        $this->ui   = $ui;
        $this->data = $data;
    }

    /**
     * Get the view data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
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
 