<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

class BuildTableOptionsCommandHandler
{
    public function handle(BuildTableOptionsCommand $command)
    {
        $ui = $command->getUi();

        $paginate   = evaluate($ui->getPaginate(), [$ui]);
        $sortable   = evaluate($ui->getSortable(), [$ui]);
        $tableClass = evaluate($ui->getTableClass(), [$ui]);

        return compact('paginate', 'sortable', 'tableClass');
    }
}
 