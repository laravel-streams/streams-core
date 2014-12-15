<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Table\Event\QueryingTableEntries;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\EventListener;

/**
 * Class TableListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TableListener extends EventListener
{

    use CommanderTrait;

    /**
     * Fired when querying for table entries.
     *
     * @param QueryingTableEntries $event
     */
    public function whenQueryingTableEntries(QueryingTableEntries $event)
    {
        $table = $event->getTable();
        $query = $event->getQuery();

        if (app('request')->isMethod('post')) {
            return;
        }

        $args = compact('table', 'query');

        $this->execute('Anomaly\Streams\Platform\Ui\Table\View\Command\HandleTableViewCommand', $args);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Filter\Command\HandleTableFiltersCommand', $args);
    }
}
