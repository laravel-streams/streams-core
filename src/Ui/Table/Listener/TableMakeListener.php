<?php namespace Anomaly\Streams\Platform\Ui\Table\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableMakeEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class TableMakeListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Listener
 */
class TableMakeListener
{

    use CommanderTrait;

    /**
     * Handle the event.
     *
     * @param TableMakeEvent $event
     */
    public function handle(TableMakeEvent $event)
    {
        $table = $event->getTable();

        // Load the table to the table's data.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Command\LoadTableCommand', compact('table'));

        // Load the options to the table's data.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Command\LoadTableOptionsCommand', compact('table'));

        // Load the entries to the table's data.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Command\LoadTableEntriesCommand', compact('table'));

        // Load the pagination to the table's data.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Command\LoadTablePaginationCommand', compact('table'));
    }
}
