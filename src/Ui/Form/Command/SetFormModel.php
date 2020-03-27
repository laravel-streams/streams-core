<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class SetFormModel
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SetFormModel
{

    /**
     * Handle the form.
     * 
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        $form  = $builder->getForm();
        $model = $builder->getModel();
        $entry = $builder->getEntry();

        /*
         * If the model is already instantiated
         * then use it as is.
         */
        if (is_object($model)) {

            $form->setModel($model);

            return;
        }

        /*
         * If no model is set, fist try
         * guessing the model based on the entry.
         */
        if ($model === null && is_object($entry)) {

            $stream = $entry->stream();

            $builder->setModel($model = get_class($stream->model));
        }

        /*
         * If no model is set, try guessing the
         * model based on best practices.
         */
        if ($model === null) {

            $parts = explode('\\', str_replace('FormBuilder', 'Model', get_class($builder)));

            unset($parts[count($parts) - 2]);

            $model = implode('\\', $parts);

            $builder->setModel($model);
        }

        /*
         * If the model does not exist or
         * is disabled then skip it.
         */
        if (!$model || !class_exists($model)) {

            $builder->setModel(null);

            return;
        }

        /*
         * Set the model on the form!
         */
        $form->setModel(app($model));
    }
}
