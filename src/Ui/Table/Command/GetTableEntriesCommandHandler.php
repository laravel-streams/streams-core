<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableModelInterface;

/**
 * Class GetTableEntriesCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Command
 */
class GetTableEntriesCommandHandler
{

    /**
     * Load entries onto the table.
     *
     * @param GetTableEntriesCommand $command
     */
    public function handle(GetTableEntriesCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $model   = $builder->getModel();
        $entries = $table->getEntries();

        /**
         * If the entries have already been set on the
         * table then return. Nothing to do here.
         *
         * If the model is not set then they need
         * to load the table entries themselves.
         */
        if (!$entries->isEmpty() || !class_exists($model)) {
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
