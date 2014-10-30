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

        $paginate   = evaluate($ui->getPaginate(), [$ui]);
        $sortable   = evaluate($ui->getSortable(), [$ui]);
        $tableClass = evaluate($ui->getTableClass(), [$ui]);

        return compact('paginate', 'sortable', 'tableClass');
    }
}
 