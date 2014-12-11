<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

class SetTableDataCommandHandler
{
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
