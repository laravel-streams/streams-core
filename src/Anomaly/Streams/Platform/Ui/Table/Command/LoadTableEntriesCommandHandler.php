<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableModelInterface;

/**
 * Class LoadTableEntriesCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class LoadTableEntriesCommandHandler
{
    /**
     * Handle the command.
     *
     * @param LoadTableEntriesCommand $command
     */
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
