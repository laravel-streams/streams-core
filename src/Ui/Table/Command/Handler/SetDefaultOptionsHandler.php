<?php namespace Anomaly\Streams\Platform\Ui\Table\Command\Handler;

use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\Command\SetDefaultOptions;

/**
 * Class SetDefaultOptionsHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Command
 */
class SetDefaultOptionsHandler
{

    /**
     * Set the table model object from the builder's model.
     *
     * @param SetDefaultOptions $command
     */
    public function handle(SetDefaultOptions $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();

        /**
         * Set the default options handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$table->getOption('options')) {

            $options = str_replace('TableBuilder', 'TableOptions', get_class($builder));

            if (class_exists($options)) {
                $table->setOption('options', $options . '@handle');
            }
        }

        /**
         * Set a optional entries handler based
         * on the builder class. Defaulting to
         * no handler in which case we will use
         * the model and included repositories.
         */
        if (!$table->getOption('entries')) {

            $entries = str_replace('TableBuilder', 'TableEntries', get_class($builder));

            if (!class_exists($entries)) {
                $table->setOption('entries', $entries . '@handle');
            }
        }

        /**
         * Set the default options handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$table->getOption('repository')) {

            $model = $table->getModel();

            if (!$table->getOption('repository') && $model instanceof EntryModel) {
                $table->setOption('repository', 'Anomaly\Streams\Platform\Entry\EntryTableRepository');
            }

            if (!$table->getOption('repository') && $model instanceof EntryModel) {
                $table->setOption('repository', 'Anomaly\Streams\Platform\Model\EloquentTableRepository');
            }
        }
    }
}
