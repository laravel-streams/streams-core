<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableBuildEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class TablePostListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Listener
 */
class TablePostListener
{

    use CommanderTrait;

    /**
     * Handle the event.
     *
     * @param TableBuildEvent $event
     */
    public function handle(TableBuildEvent $event)
    {
        // Run the active action's TablePostHandler.
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\RunTablePostHookCommand',
            compact('event')
        );
    }
}
