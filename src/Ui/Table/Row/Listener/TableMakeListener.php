<?php namespace Anomaly\Streams\Platform\Ui\Table\Row\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableMakeEvent;
use Anomaly\Streams\Platform\Ui\Table\Row\RowLoader;

/**
 * Class TableMakeListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Row\Listener
 */
class TableMakeListener
{

    /**
     * The row data object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Row\RowLoader
     */
    protected $data;

    /**
     * Create a new TableMakeListener instance.
     *
     * @param RowLoader $data
     */
    public function __construct(RowLoader $data)
    {
        $this->data = $data;
    }

    /**
     * When the table is being made we need to put the
     * row data to the table.
     *
     * @param TableMakeEvent $event
     */
    public function handle(TableMakeEvent $event)
    {
        $this->data->load($event->getBuilder());
    }
}
