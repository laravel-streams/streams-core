<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableQueryEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class TableQueryListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View\Listener
 */
class TableQueryListener
{

    use CommanderTrait;

    /**
     * Handle the command.
     *
     * @param TableQueryEvent $event
     */
    public function handle(TableQueryEvent $event)
    {
        // Run TableQueryEvent handlers on active filters.
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\View\Command\RunTableQueryHookCommand',
            compact('event')
        );
    }
}
