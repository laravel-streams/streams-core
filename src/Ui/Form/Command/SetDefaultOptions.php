<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetDefaultOptions
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class SetDefaultOptions implements SelfHandling
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new BuildFormColumnsCommand instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $form = $this->builder->getForm();

        /**
         * Set the default form handler based
         * on the builder class. Defaulting to
         * the base handler.
         */
        if (!$form->getOption('handler')) {

            $handler = str_replace('FormBuilder', 'FormHandler', get_class($this->builder));

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

            $validator = str_replace('FormBuilder', 'FormValidator', get_class($this->builder));

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

            $options = str_replace('FormBuilder', 'FormOptions', get_class($this->builder));

            if (class_exists($options)) {
                app()->call($options . '@handle', ['builder' => $this->builder]);
            }
        }

        /**
         * Set the default data handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$form->getOption('data')) {

            $options = str_replace('FormBuilder', 'FormData', get_class($this->builder));

            if (class_exists($options)) {
                $form->setOption('data', $options . '@handle');
            }
        }

        /**
         * Set the default options handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$form->getOption('repository')) {

            $model = $form->getModel();

            $repository = str_replace('FormBuilder', 'FormRepository', get_class($this->builder));

            if (!$form->getOption('repository') && class_exists($repository)) {
                $form->setOption('repository', $repository);
            } elseif (!$form->getOption('repository') && $model instanceof EntryModel) {
                $form->setOption('repository', 'Anomaly\Streams\Platform\Entry\EntryFormRepository');
            } elseif (!$form->getOption('repository') && $model instanceof EloquentModel) {
                $form->setOption('repository', 'Anomaly\Streams\Platform\Model\EloquentFormRepository');
            }
        }

        /**
         * If the form is ajax and there is no title
         * just use a blank space so that the modal
         * header does not collapse.
         */
        if ($this->builder->isAjax() && !$form->getOption('title')) {
            $form->setOption('title', '&nbsp;');
        }
    }
}
