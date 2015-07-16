<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetFormModel
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class SetFormModel implements SelfHandling
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
     * Handle the form.
     */
    public function handle()
    {
        $form  = $this->builder->getForm();
        $model = $this->builder->getModel();

        /**
         * If the model is already instantiated
         * then use it as is.
         */
        if (is_object($model)) {

            $form->setModel($model);

            return;
        }

        /**
         * If no model is set, try guessing the
         * model based on best practices.
         */
        if ($model === null) {

            $parts = explode('\\', str_replace('FormBuilder', 'Model', get_class($this->builder)));

            unset($parts[count($parts) - 2]);

            $model = implode('\\', $parts);

            $this->builder->setModel($model);
        }

        /**
         * If the model does not exist or
         * is disabled then skip it.
         */
        if (!$model || !class_exists($model)) {

            $this->builder->setModel(null);

            return;
        }

        /**
         * Set the model on the form!
         */
        $form->setModel(app($model));
    }
}
