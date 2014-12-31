<?php namespace Anomaly\Streams\Platform\Ui\Table\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableQueryEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class TableQueryListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Listener
 */
class TableQueryListener
{

    use CommanderTrait;

    /**
     * Handle the event.
     *
     * @param TableQueryEvent $event
     */
    public function handle(TableQueryEvent $event)
    {
        $table = $event->getTable();
        $query = $event->getQuery();

        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Command\ModifyQueryCommand',
            compact('table', 'query')
        );
    }
}
