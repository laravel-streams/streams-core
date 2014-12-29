<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableBuildEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class TableBuildListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Listener
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

        // Build action objects and load them onto the table.
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\BuildActionsCommand',
            compact('builder')
        );

        // Mark the active action if there is one.
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\SetActiveActionCommand',
            compact('builder')
        );
    }
}
