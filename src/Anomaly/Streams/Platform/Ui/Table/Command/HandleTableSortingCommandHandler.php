<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

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
     * @return mixed
     */
    public function handle(HandleTableSortingCommand $command)
    {
        $table = $command->getTable();

        $key = $table->getPrefix() . 'order_by';

        /**
         * Set the ordering on the table.
         * We will hook onto the column later
         * if it is a field slug.
         */
        if ($orderBy = app('request')->get($key)) {

            list($column, $direction) = explode('|', $orderBy);

            $table->setOrderBy([$column => $direction]);
        }
    }
}
 