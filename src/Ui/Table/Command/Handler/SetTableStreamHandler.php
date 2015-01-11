<?php namespace Anomaly\Streams\Platform\Ui\Table\Command\Handler;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Table\Command\SetTableStream;

/**
 * Class SetTableStreamHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Command
 */
class SetTableStreamHandler
{

    /**
     * Set the table stream from the builder's model.
     *
     * @param SetTableStream $command
     */
    public function handle(SetTableStream $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $model   = $builder->getModel();

        /**
         * If the model is not set then they need
         * to load the table entries themselves.
         */
        if (!class_exists($model)) {
            return;
        }

        /*
         * Resolve the model
         * from the container.
         */
        $model = app($model);

        /**
         * If the model happens to be an instance of
         * EntryInterface then set the stream on the table.
         */
        if ($model instanceof EntryInterface) {
            $table->setStream($model->getStream());
        }
    }
}
