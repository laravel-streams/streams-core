<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Table\Event\QueryingTableEntries;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\EventListener;

class TableListener extends EventListener
{

    use CommanderTrait;

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
 