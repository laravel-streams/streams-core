<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Table\Event\QueryingTableEntries;
use Laracasts\Commander\Events\EventListener;

class TableListener extends EventListener
{

    public function whenQueryingTableEntries(QueryingTableEntries $event)
    {
        if (app('request')->isMethod('post')) {

            return;
        }
        
        $query = $event->getQuery();
        $table = $event->getTable();

        $filters = $table->getFilters();

        foreach ($filters->active() as $filter) {

            $handler = $filter->getHandler();

            if (is_string($handler) or $handler instanceof \Closure) {

                app()->call($handler, compact('table', 'query'));
            }

            if ($handler === null) {

                $filter->handle($table, $query);
            }
        }
    }
}
 