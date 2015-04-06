<?php namespace Anomaly\Streams\Platform\Ui\Table\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Command\GetTableEntries;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Class GetTableEntriesHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class GetTableEntriesHandler
{

    /**
     * Handle the command.
     *
     * @param GetTableEntries $command
     * @return null|Collection
     */
    public function handle(GetTableEntries $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $model   = $builder->getModel();
        $entries = $table->getEntries();

        /**
         * If the builder has an entries handler
         * then call it through the container and
         * let it load the entries itself.
         */
        if ($handler = $table->getOption('entries')) {
            app()->call($handler, compact('table'));
        }

        /**
         * If the entries have already been set on the
         * table then return. Nothing to do here.
         *
         * If the model is not set then they need
         * to load the table entries themselves.
         */
        if (!$entries->isEmpty() || !$model) {
            return null;
        }

        /**
         * Resolve the model out of the container.
         */
        $repository = $table->getRepository();

        /**
         * If the repository is not an instance of
         * TableRepositoryInterface then they need to load
         * the entries themselves.
         */
        if (!$repository instanceof TableRepositoryInterface) {
            return null;
        }

        /**
         * Get table entries and set them on the table.
         */
        $table->setEntries($repository->get($builder));
    }
}
