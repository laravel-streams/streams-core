<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableLoadEvent;

/**
 * Class TableLoadListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Column\Listener
 */
class TableLoadListener
{

    /**
     * Handle the event.
     *
     * @param TableLoadEvent $event
     */
    public function handle(TableLoadEvent $event)
    {
        $table = $event->getTable();

        $data    = $table->getData();
        $columns = $table->getColumns();

        $data->put('columns', $columns);
    }
}
