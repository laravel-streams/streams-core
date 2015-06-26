<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetDefaultParameters
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class SetDefaultParameters implements SelfHandling
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
     * Set the form model object from the builder's model.
     *
     * @param SetDefaultParameters $command
     */
    public function handle()
    {
        /**
         * Set the default form handler based
         * on the builder class. Defaulting to
         * the base handler.
         */
        if (!$this->builder->getHandler()) {

            $handler = str_replace('FormBuilder', 'FormHandler', get_class($this->builder));

            if (class_exists($handler)) {
                $this->builder->setHandler($handler . '@handle');
            } else {
                $this->builder->setHandler('Anomaly\Streams\Platform\Ui\Form\FormHandler@handle');
            }
        }

        /**
         * Set the default fields handler based
         * on the builder class. Defaulting to
         * all fields.
         */
        if (!$this->builder->getFields()) {

            $fields = str_replace('FormBuilder', 'FormFields', get_class($this->builder));

            if (class_exists($fields)) {
                $this->builder->setFields($fields . '@handle');
            } else {
                $this->builder->setFields(['*']);
            }
        }

        /**
         * Set the default actions handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$this->builder->getActions()) {

            $actions = str_replace('FormBuilder', 'FormActions', get_class($this->builder));

            if (class_exists($actions)) {
                $this->builder->setActions($actions . '@handle');
            }
        }

        /**
         * Set the default buttons handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$this->builder->getButtons()) {

            $buttons = str_replace('FormBuilder', 'FormButtons', get_class($this->builder));

            if (class_exists($buttons)) {
                $this->builder->setButtons($buttons . '@handle');
            }
        }

        /**
         * Set the default form sections based
         * on the builder class. Defaulting to
         * no sections.
         */
        if (!$this->builder->getSections()) {

            $sections = str_replace('FormBuilder', 'FormSections', get_class($this->builder));

            if (class_exists($sections)) {
                $this->builder->setSections($sections . '@handle');
            }
        }

        /**
         * Set the form mode according to the builder's entry.
         */
        if (!$this->builder->getFormMode()) {
            $this->builder->setFormMode($this->builder->getEntry() ? 'edit' : 'create');
        }
    }
}
