<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Listener;

use Anomaly\Streams\Platform\Ui\Table\Action\ActionData;
use Anomaly\Streams\Platform\Ui\Table\Event\TableMakeEvent;

/**
 * Class TableMakeListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action\Listener
 */
class TableMakeListener
{

    /**
     * The action data object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Action\ActionData
     */
    protected $data;

    /**
     * Create a new TableMakeListener instance.
     *
     * @param ActionData $data
     */
    public function __construct(ActionData $data)
    {
        $this->data = $data;
    }

    /**
     * When the table is being made we need to put the
     * action data to the table.
     *
     * @param TableMakeEvent $event
     */
    public function handle(TableMakeEvent $event)
    {
        $this->data->make($event->getBuilder());
    }
}
