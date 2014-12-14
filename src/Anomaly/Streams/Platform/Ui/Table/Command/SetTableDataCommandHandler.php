<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

/**
 * Class SetTableDataCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class SetTableDataCommandHandler
{
    /**
     * Handle the command.
     *
     * @param SetTableDataCommand $command
     */
    public function handle(SetTableDataCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();

        $table->putData('prefix', $table->getPrefix());
        $table->putData('sortable', $table->isSortable());
        $table->putData('filtering', ($table->getFilters()->active()->count()));
        $table->putData('noResultsMessage', trans($table->getNoResultsMessage()));
    }
}
