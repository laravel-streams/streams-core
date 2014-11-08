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

        $prefix           = evaluate($table->getPrefix(), [$table]);
        $paginate         = evaluate($table->getPaginate(), [$table]);
        $sortable         = evaluate($table->getSortable(), [$table]);
        $tableClass       = evaluate($table->getTableClass(), [$table]);
        $noResultsMessage = trans(evaluate($table->getNoResultsMessage()));
        $activeView       = app('request')->get($table->getPrefix() . 'view', 'all');
        $filterState      = app('request')->get($table->getPrefix() . 'filter', null);

        return compact('paginate', 'sortable', 'tableClass', 'prefix', 'noResultsMessage', 'activeView', 'filterState');
    }
}
 