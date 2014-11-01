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
        $ui = $command->getUi();

        $prefix           = evaluate($ui->getPrefix(), [$ui]);
        $paginate         = evaluate($ui->getPaginate(), [$ui]);
        $sortable         = evaluate($ui->getSortable(), [$ui]);
        $tableClass       = evaluate($ui->getTableClass(), [$ui]);
        $noResultsMessage = trans(evaluate($ui->getNoResultsMessage()));
        $activeView       = app('request')->get($ui->getPrefix() . 'view', 'all');
        $filterState      = app('request')->get($ui->getPrefix() . 'filter', null);

        return compact('paginate', 'sortable', 'tableClass', 'prefix', 'noResultsMessage', 'activeView', 'filterState');
    }
}
 