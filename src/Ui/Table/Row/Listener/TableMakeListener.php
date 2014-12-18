<?php namespace Anomaly\Streams\Platform\Ui\Table\Row\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableMakeEvent;
use Anomaly\Streams\Platform\Ui\Table\Row\RowData;

/**
 * Class TableMakeListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Row\Listener
 */
class TableMakeListener
{

    /**
     * The row data object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Row\RowData
     */
    protected $data;

    /**
     * Create a new TableMakeListener instance.
     *
     * @param RowData $data
     */
    public function __construct(RowData $data)
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
        $this->data->make($event->getBuilder());
    }
}
