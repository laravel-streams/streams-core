<?php namespace Anomaly\Streams\Platform\Ui\Table\Row\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableLoadEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class TableLoadListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Row\Listener
 */
class TableLoadListener
{

    use CommanderTrait;

    /**
     * When the table is building we want to build and push
     * the views onto the table's view collection.
     *
     * @param TableLoadEvent $event
     */
    public function handle(TableLoadEvent $event)
    {
        $builder = $event->getBuilder();

        $this->execute('Anomaly\Streams\Platform\Ui\Table\Row\Command\BuildTableRowsCommand', compact('builder'));
    }
}
