<?php namespace Anomaly\Streams\Platform\Ui\Table\Row\Command;

use Anomaly\Streams\Platform\Ui\Table\Row\Contract\RowInterface;

class SetRowDataCommandHandler
{

    public function handle(SetRowDataCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();

        $rows = [];

        foreach ($table->getRows() as $row) {

            if ($row instanceof RowInterface) {

                $rows[] = $row->viewData();
            }
        }

        $table->putData('rows', $rows);
    }
}
 