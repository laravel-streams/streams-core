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

            $options = str_replace('FormBuilder', 'FormOptions', get_class($builder));

            if (!class_exists($options)) {
                $options = null;
            }

            $table->setOption('options', $options . '@handler');
        }

        /**
         * Set the default options handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$repository = $table->getOption('repository')) {

            $model = $table->getModel();

            if (!$repository && $model instanceof EntryModel) {
                $repository = 'Anomaly\Streams\Platform\Entry\EntryTableRepository';
            }

            if (!$repository && $model instanceof EloquentModel) {
                $repository = 'Anomaly\Streams\Platform\Model\EloquentTableRepository';
            }

            if ($repository) {
                $table->setOption('repository', $repository);
            }
        }
    }
}
