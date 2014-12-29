<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableBuildEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class TableBuildListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Column\Listener
 */
class TableBuildListener
{

    use CommanderTrait;

    /**
     * Handle the event.
     *
     * @param TableBuildEvent $event
     */
    public function handle(TableBuildEvent $event)
    {
        $builder = $event->getBuilder();

        // Build column objects and load them onto the table.
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\Column\Command\BuildColumnsCommand',
            compact('builder')
        );
    }
}
