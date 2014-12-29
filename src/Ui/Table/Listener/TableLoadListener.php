<?php namespace Anomaly\Streams\Platform\Ui\Table\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableLoadEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class TableLoadListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Listener
 */
class TableLoadListener
{

    use CommanderTrait;

    /**
     * Handle the event.
     *
     * @param TableLoadEvent $event
     */
    public function handle(TableLoadEvent $event)
    {
        $table = $event->getTable();

        // Load the options to the table's data.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Command\LoadTableOptionsCommand', compact('table'));
    }
}
