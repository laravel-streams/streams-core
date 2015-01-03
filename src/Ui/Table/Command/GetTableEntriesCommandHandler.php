<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableModelInterface;
use Illuminate\Support\Collection;

/**
 * Class GetTableEntriesCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class GetTableEntriesCommandHandler
{

    /**
     * Handle the command.
     *
     * @param GetTableEntriesCommand $command
     * @return null|Collection
     */
    public function handle(GetTableEntriesCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $model   = $builder->getModel();
        $entries = $table->getEntries();

        /**
         * If the builder has an entries handler
         * then call it through the container.
         */
        if ($handler = $builder->getEntries()) {

            $entries = app()->call($handler, compact('table'));

            if ($entries instanceof Collection) {
                $table->setEntries($entries);
            }
        }

        /**
         * If the entries have already been set on the
         * table then return. Nothing to do here.
         *
         * If the model is not set then they need
         * to load the table entries themselves.
         */
        if (!$entries->isEmpty() || !class_exists($model)) {
            return null;
        }

        /**
         * Resolve the model out of the container.
         */
        $model = app($model);

        /**
         * If the set the model is not an instance of
         * TableModelInterface then they need to load
         * the entries themselves.
         */
        if (!$model instanceof TableModelInterface) {
            return null;
        }

        /**
         * Get table entries and set them on the table.
         */
        if ($entries = $model->getTableEntries($table)) {
            $table->setEntries($entries);
        }
    }
}
