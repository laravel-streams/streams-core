<?php namespace Anomaly\Streams\Platform\Ui\Form\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Command\SetFormRepository;

/**
 * Class SetFormRepositoryHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class SetFormRepositoryHandler
{

    /**
     * Set the form model object from the builder's model.
     *
     * @param SetFormRepository $command
     */
    public function handle(SetFormRepository $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();
        $model   = $form->getModel();

        $repository = $form->getOption('repository');

        /**
         * Set the repository on the form!
         */
        $form->setRepository(app()->make($repository, compact('model', 'form')));
    }
}
