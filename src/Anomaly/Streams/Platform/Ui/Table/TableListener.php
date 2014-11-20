<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Support\Listener;
use Anomaly\Streams\Platform\Ui\Table\Command\HandleTableFiltersCommand;
use Anomaly\Streams\Platform\Ui\Table\Command\HandleTableSortingCommand;
use Anomaly\Streams\Platform\Ui\Table\Command\HandleTableViewCommand;
use Anomaly\Streams\Platform\Ui\Table\Event\QueryingEvent;

/**
 * Class TableListener
 *
 * This class listens for events within this namespace.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TableListener extends Listener
{

    /**
     * When the query is started apply our
     * view, sorting and filter modifications.
     *
     * @param QueryingEvent $event
     */
    public function whenQuerying(QueryingEvent $event)
    {
        $table = $event->getTable();

        $query = $table->getQuery();

        $query = $this->execute(new HandleTableViewCommand($this, $query));
        $query = $this->execute(new HandleTableSortingCommand($this, $query));
        $query = $this->execute(new HandleTableFiltersCommand($this, $query));

        $table->setQuery($query);
    }
}
 