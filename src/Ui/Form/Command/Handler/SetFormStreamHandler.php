<?php namespace Anomaly\Streams\Platform\Ui\Form\Command\Handler;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Form\Command\SetFormStream;

/**
 * Class SetFormStreamHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class SetFormStreamHandler
{

    /**
     * Set the form stream from the builder's model.
     *
     * @param SetFormStream $command
     */
    public function handle(SetFormStream $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();
        $model   = $builder->getModel();

        /**
         * If the model is not set then they need
         * to load the form entries themselves.
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
         * EntryInterface then set the stream on the form.
         */
        if ($model instanceof EntryInterface) {
            $form->setStream($model->getStream());
        }
    }
}
