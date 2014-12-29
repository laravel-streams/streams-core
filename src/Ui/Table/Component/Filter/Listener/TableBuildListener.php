<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableBuildEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class TableBuildListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter\Listener
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
        $table   = $builder->getTable();

        // Build filter objects and load them onto the table.
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\BuildFiltersCommand',
            compact('builder')
        );

        // Mark the active filter if there is one.
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\SetActiveFiltersCommand',
            compact('table')
        );
    }
}
