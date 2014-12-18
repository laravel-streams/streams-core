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
     * Load entries onto the table.
     *
     * @param LoadTableEntriesCommand $command
     */
    public function handle(LoadTableEntriesCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $model   = $builder->getModel();
        $entries = $table->getEntries();

        /**
         * If the entries have already been set on the
         * table then return. Nothing to do here.
         */
        if (!$entries->isEmpty()) {
            return;
        }

        /**
         * If the model is not set then they need
         * to load the table entries themselves.
         */
        if (!class_exists($model)) {
            return;
        }

        $model = app($model);

        /**
         * If the set the model is not an instance of
         * TableModelInterface then they need to load
         * the entries themselves.
         */
        if (!$model instanceof TableModelInterface) {
            return;
        }

        foreach ($model->getTableEntries($builder) as $entry) {
            $entries->push($entry);
        }
    }
}
