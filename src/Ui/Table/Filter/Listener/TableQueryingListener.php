<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Listener;

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
        $builder = $event->getBuilder();
        $query   = $event->getQuery();

        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Filter\Command\ApplyTableFiltersCommand',
            compact('builder', 'query')
        );
    }
}
