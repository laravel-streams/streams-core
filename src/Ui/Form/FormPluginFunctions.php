<?php namespace Anomaly\Streams\Platform\Ui\Form;

/**
 * Class FormPluginFunctions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormPluginFunctions
{

    /**
     * Render the form's layout.
     *
     * @param Form $form
     * @return \Illuminate\View\View
     */
    public function toolbar(Form $form)
    {
        $options = $form->getOptions();

        return view($options->get('toolbar', 'streams::ui/form/partials/toolbar'), compact('form'));
    }

    /**
     * Render the form's layout.
     *
     * @param Form $form
     * @return \Illuminate\View\View
     */
    public function layout(Form $form)
    {
        $options = $form->getOptions();

        return view($options->get('layout', 'streams::ui/form/partials/layout'), compact('form'));
    }

    /**
     * Render the form's controls.
     *
     * @param Form $form
     * @return \Illuminate\View\View
     */
    public function controls(Form $form)
    {
        $options = $form->getOptions();

        return view($options->get('controls', 'streams::ui/form/partials/controls'), compact('form'));
    }
}
