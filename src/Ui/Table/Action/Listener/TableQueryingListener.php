<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableQueryingEvent;

/**
 * Class TableQueryingListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Action\Listener
 */
class TableQueryingListener
{

    /**
     * Handle the event.
     *
     * @param TableQueryingEvent $event
     */
    public function handle(TableQueryingEvent $event)
    {
        $table = $event->getTable();

        $actions = $table->getActions();

        $activeAction = $actions->active();

        $activeAction->onTableQuerying($event);
    }
}
