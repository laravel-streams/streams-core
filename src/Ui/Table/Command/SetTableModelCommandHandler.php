<?php namespace Anomaly\Streams\Platform\Ui\Table\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Command\SetTableModelCommand;

/**
 * Class SetTableModelCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Command
 */
class SetTableModelCommandHandler
{

    /**
     * Set the table model object from the builder's model.
     *
     * @param SetTableModelCommand $command
     */
    public function handle(SetTableModelCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $model   = $builder->getModel();

        /**
         * If the model is not set then skip it.
         */
        if (!class_exists($model)) {
            return;
        }

        /**
         * Set the model on the table!
         */
        $table->setModel(app($model));
    }
}
