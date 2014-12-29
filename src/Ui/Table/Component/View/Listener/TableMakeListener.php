<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableMakeEvent;

/**
 * Class TableMakeListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View\Listener
 */
class TableMakeListener
{

    /**
     * Handle the event.
     *
     * @param TableMakeEvent $event
     */
    public function handle(TableMakeEvent $event)
    {
        $table = $event->getTable();

        $data  = $table->getData();
        $views = $table->getViews();

        $data->put('views', $views);
    }
}
