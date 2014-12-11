<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormModelInterface;

class FormHandler
{
    public function handle(FormBuilder $builder)
    {
        $model = $builder->getModel();
        $form  = $builder->getForm();

        if ($model instanceof FormModelInterface) {
            $model::saveFormInput($form);
        }
    }
}
