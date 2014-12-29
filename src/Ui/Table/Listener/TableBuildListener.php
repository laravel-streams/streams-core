<?php namespace Anomaly\Streams\Platform\Ui\Table\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableBuildEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class TableBuildListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Listener
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

        // Set the table's model object from the builder's model.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Command\SetTableModelCommand', compact('builder'));

        // Set the table's stream object based on the builder's model.
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Command\SetTableStreamCommand', compact('builder'));
    }
}
