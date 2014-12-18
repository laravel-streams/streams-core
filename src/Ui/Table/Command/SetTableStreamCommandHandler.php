<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

/**
 * Class SetTableStreamCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class SetTableStreamCommandHandler
{

    /**
     * Set the table stream from the builder's model.
     *
     * @param SetTableStreamCommand $command
     */
    public function handle(SetTableStreamCommand $command)
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
