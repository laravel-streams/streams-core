<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableModelInterface;

class LoadTableEntriesCommandHandler
{

    public function handle(LoadTableEntriesCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $model   = $builder->getModel();
        $entries = $table->getEntries();

        if (!$model instanceof TableModelInterface) {

            return;
        }

        foreach ($model->getTableEntries($table) as $entry) {

            $entries->push($entry);
        }
    }
}
 