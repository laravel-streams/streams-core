<?php namespace Anomaly\Streams\Platform\Ui\Table\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableReadyEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class TableReadyListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Listener
 */
class TableReadyListener
{

    use CommanderTrait;

    /**
     * Handle the event.
     *
     * @param TableReadyEvent $event
     */
    public function handle(TableReadyEvent $event)
    {
        $builder = $event->getBuilder();

        // Get entries for the table.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Command\GetTableEntriesCommand', compact('builder'));
    }
}
