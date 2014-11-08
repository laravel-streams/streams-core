<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Illuminate\Http\Request;

/**
 * Class HandleTableSortingCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTableSortingCommandHandler
{

    /**
     * @param HandleTableSortingCommand $command
     * @param Request                   $request
     * @return mixed
     */
    public function handle(HandleTableSortingCommand $command, Request $request)
    {
        $table = $command->getTable();
        $query = $command->getQuery();

        $key = $table->getPrefix() . 'order_by';

        /**
         * Set the ordering on the table and
         * return the query as is. We will hook
         * into it later for relational joining
         * and what not.
         */
        if ($orderBy = $request->get($key)) {

            list($column, $direction) = explode('|', $orderBy);

            $table->setOrderBy([$column => $direction]);
        }

        return $query;
    }
}
 