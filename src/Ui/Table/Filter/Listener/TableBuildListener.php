<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableBuildEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class TableLoadListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Filter\Listener
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

        $this->execute('Anomaly\Streams\Platform\Ui\Table\Filter\Command\BuildTableFiltersCommand', compact('builder'));
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Filter\Command\SetActiveFiltersCommand', compact('builder'));
    }
}
