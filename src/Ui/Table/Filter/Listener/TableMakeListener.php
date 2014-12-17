<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableMakeEvent;
use Anomaly\Streams\Platform\Ui\Table\Filter\FilterData;

/**
 * Class TableMakeListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Filter\Listener
 */
class TableMakeListener
{

    /**
     * The filter data object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Filter\FilterData
     */
    protected $data;

    /**
     * Create a new TableMakeListener instance.
     *
     * @param FilterData $data
     */
    public function __construct(FilterData $data)
    {
        $this->data = $data;
    }

    /**
     * When a table is being made we need to
     * put the filter data to the table.
     *
     * @param TableMakeEvent $event
     */
    public function handle(TableMakeEvent $event)
    {
        $this->data->make($event->getBuilder());
    }
}
