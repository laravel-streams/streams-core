<?php namespace Anomaly\Streams\Platform\Ui\Table\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableMakeEvent;
use Anomaly\Streams\Platform\Ui\Table\TableData;

/**
 * Class TableMakeListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Listener
 */
class TableMakeListener
{

    /**
     * The table data object.
     *
     * @var TableData
     */
    protected $data;

    /**
     * Create a new TableMakeListener instance.
     *
     * @param TableData $data
     */
    function __construct(TableData $data)
    {
        $this->data = $data;
    }

    /**
     * When the table is being made we want to put
     * the odds n ends data to the table.
     *
     * @param TableMakeEvent $event
     */
    public function handle(TableMakeEvent $event)
    {
        $this->data->make($event->getBuilder());
    }
}
