<?php namespace Anomaly\Streams\Platform\Ui\Table\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableQueryingEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class TableQueryingListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Listener
 */
class TableQueryingListener
{

    use CommanderTrait;

    /**
     * When querying entries for the table we need to
     * hook into some of our table features.
     *
     * @param TableQueryingEvent $event
     */
    public function handle(TableQueryingEvent $event)
    {
        $table = $event->getTable();
        $query = $event->getQuery();

        if (app('request')->isMethod('post')) {
            return;
        }

        $args = compact('table', 'query');

        $this->execute('Anomaly\Streams\Platform\Ui\Table\View\Command\HandleTableViewCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Filter\Command\HandleTableFiltersCommand', $args);
    }
}
