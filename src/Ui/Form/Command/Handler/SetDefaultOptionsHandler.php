<?php namespace Anomaly\Streams\Platform\Ui\Form\Command\Handler;

use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Form\Command\SetDefaultOptions;

/**
 * Class SetDefaultOptionsHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class SetDefaultOptionsHandler
{

    /**
     * Set the form model object from the builder's model.
     *
     * @param SetDefaultOptions $command
     */
    public function handle(SetDefaultOptions $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();

        /**
         * Set the default form handler based
         * on the builder class. Defaulting to
         * the base handler.
         */
        if (!$form->getOption('handler')) {

            $handler = str_replace('FormBuilder', 'FormHandler', get_class($builder));

            if (!class_exists($handler)) {
                $handler = 'Anomaly\Streams\Platform\Ui\Form\FormHandler';
            }

            $form->setOption('handler', $handler . '@handle');
        }

        /**
         * Set the default form validator based
         * on the builder class. Defaulting to
         * the base validator.
         */
        if (!$form->getOption('validator')) {

            $validator = str_replace('FormBuilder', 'FormValidator', get_class($builder));

            if (!class_exists($validator)) {
                $validator = 'Anomaly\Streams\Platform\Ui\Form\FormValidator';
            }

            $form->setOption('validator', $validator . '@validate');
        }

        /**
         * Set the default options handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$form->getOption('options')) {

            $options = str_replace('FormBuilder', 'FormOptions', get_class($builder));

            if (class_exists($options)) {
                $form->setOption('options', $options . '@handle');
            }
        }

        /**
         * Set the default data handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$form->getOption('data')) {

            $options = str_replace('FormBuilder', 'FormData', get_class($builder));

            if (class_exists($options)) {
                $form->setOption('data', $options . '@handle');
            }
        }

        /**
         * Set the default options handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$repository = $form->getOption('repository')) {

            $model = $form->getModel();

            if (!$form->getOption('repository') && $model instanceof EntryModel) {
                $form->setOption('repository', 'Anomaly\Streams\Platform\Entry\EntryFormRepository');
            }

            if (!$form->getOption('repository') && $model instanceof EloquentModel) {
                $form->setOption('repository', 'Anomaly\Streams\Platform\Model\EloquentFormRepository');
            }
        }
    }
}
