<?php namespace Anomaly\Streams\Platform\Ui\Table\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Command\SetTableRepository;

/**
 * Class SetTableRepositoryHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Command
 */
class SetTableRepositoryHandler
{

    /**
     * Set the table model object from the builder's model.
     *
     * @param SetTableRepository $command
     */
    public function handle(SetTableRepository $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $model   = $table->getModel();

        $repository = $table->getOption('repository');

        /**
         * Set the repository on the form!
         */
        $table->setRepository(app()->make($repository, compact('model', 'table')));
    }
}
