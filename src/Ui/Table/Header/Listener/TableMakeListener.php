<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableMakeEvent;
use Anomaly\Streams\Platform\Ui\Table\Header\HeaderData;

/**
 * Class TableMakeListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Header\Listener
 */
class TableMakeListener
{

    /**
     * The table data object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Header\HeaderData
     */
    protected $data;

    /**
     * Create a new TableMakeListener instance.
     *
     * @param HeaderData $data
     */
    function __construct(HeaderData $data)
    {
        $this->data = $data;
    }

    /**
     * When the table is being made we need to
     * put the header data to the table.
     *
     * @param TableMakeEvent $event
     */
    public function handle(TableMakeEvent $event)
    {
        $this->data->make($event->getBuilder());
    }
}
