<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableMakeEvent;
use Anomaly\Streams\Platform\Ui\Table\View\ViewData;

/**
 * Class TableMakeListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\View\Listener
 */
class TableMakeListener
{

    /**
     * The view data object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\View\ViewData
     */
    protected $data;

    /**
     * Create a new TableMakeListener instance.
     *
     * @param ViewData $data
     */
    public function __construct(ViewData $data)
    {
        $this->data = $data;
    }

    /**
     * When the table is being made we need to put the
     * view data to the table.
     *
     * @param TableMakeEvent $event
     */
    public function handle(TableMakeEvent $event)
    {
        $this->data->make($event->getBuilder());
    }
}
