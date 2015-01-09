<?php namespace Anomaly\Streams\Platform\Ui\Table\Listener;

use Anomaly\Streams\Platform\Ui\Table\Command\ModifyQueryCommand;
use Anomaly\Streams\Platform\Ui\Table\Event\TableQueryEvent;
use Illuminate\Foundation\Bus\DispatchesCommands;

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

    use DispatchesCommands;

    /**
     * Handle the event.
     *
     * @param TableQueryEvent $event
     */
    public function handle(TableQueryEvent $event)
    {
        $table = $event->getTable();
        $query = $event->getQuery();

        $this->dispatch(new ModifyQueryCommand($table, $query));
    }
}
