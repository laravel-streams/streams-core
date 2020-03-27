<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class SetFormStream
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SetFormStream
{

    /**
     * Handle the command.
     * 
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        $form  = $builder->getForm();
        $model = $builder->getModel();

        if (is_string($model) && !class_exists($model)) {
            return;
        }

        if (is_string($model)) {
            $model = app($model);
        }

        if (is_object($model)) {
            $form->setStream($model->stream());
        }
    }
}
