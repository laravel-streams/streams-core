<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

/**
 * Class BuildTableOptionsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableOptionsCommandHandler
{

    /**
     * Handle the command.
     *
     * @param BuildTableOptionsCommand $command
     * @return array
     */
    public function handle(BuildTableOptionsCommand $command)
    {
        $table = $command->getTable();

        $noResultsMessage = trans(evaluate($table->getNoResultsMessage()));

        $prefix     = evaluate($table->getPrefix(), compact('table'));
        $paginate   = evaluate($table->getPaginate(), compact('table'));
        $sortable   = evaluate($table->getSortable(), compact('table'));
        $tableClass = evaluate($table->getTableClass(), compact('table'));

        $filterState = app('request')->get($table->getPrefix() . 'filter', false);

        return compact('paginate', 'sortable', 'tableClass', 'prefix', 'noResultsMessage', 'filterState');
    }
}
 