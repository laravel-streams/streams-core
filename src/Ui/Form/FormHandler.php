<?php namespace Anomaly\Streams\Platform\Ui\Form;

/**
 * Class FormHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form
 */
class FormHandler
{

    /**
     * Handle the form.
     *
     * @param Form $form
     */
    public function handle(Form $form)
    {
        $model = $form->getModel();

        app()->call(get_class($model) . '@saveFormInput', compact('form'));
    }
}
