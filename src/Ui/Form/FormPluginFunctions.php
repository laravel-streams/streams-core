<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Guesser\SectionViewGuesser;

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
     * The section view guesser.
     *
     * @var Guesser\SectionViewGuesser
     */
    protected $sectionViewGuesser;

    /**
     * Create a new FormPluginFunctions instance.
     *
     * @param SectionViewGuesser $sectionViewGuesser
     */
    public function __construct(SectionViewGuesser $sectionViewGuesser)
    {
        $this->sectionViewGuesser = $sectionViewGuesser;
    }

    /**
     * Render the form's layout.
     *
     * @param Form $form
     * @return \Illuminate\View\View
     */
    public function toolbar(Form $form)
    {
        $options = $form->getOptions();

        return view($options->get('toolbar_view', 'streams::ui/form/partials/toolbar'), compact('form'));
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

        return view($options->get('layout_view', 'streams::ui/form/partials/layout'), compact('form'));
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

        return view($options->get('controls_view', 'streams::ui/form/partials/controls'), compact('form'));
    }

    /**
     * Render a form section.
     *
     * @param Form  $form
     * @param array $section
     * @return \Illuminate\View\View
     */
    public function section(Form $form, array $section)
    {
        $this->sectionViewGuesser->guess($section);

        return view(array_get($section, 'view'), compact('form', 'section'));
    }
}
