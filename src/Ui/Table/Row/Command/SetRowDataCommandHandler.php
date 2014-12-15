<?php namespace Anomaly\Streams\Platform\Ui\Table\Row\Command;

use Anomaly\Streams\Platform\Ui\Table\Row\Contract\RowInterface;

/**
 * Class SetRowDataCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Row\Command
 */
class SetRowDataCommandHandler
{

    /**
     * Handle the command.
     *
     * @param SetRowDataCommand $command
     */
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
