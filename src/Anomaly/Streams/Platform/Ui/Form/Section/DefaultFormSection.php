<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Ui\Form\Command\BuildFormSectionLayoutCommand;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormSectionInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Anomaly\Streams\Platform\Ui\Form\FormSection;

/**
 * Class DefaultFormSection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Section
 */
class DefaultFormSection implements FormSectionInterface
{

    use CommandableTrait;

    /**
     * The form object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Form
     */
    protected $form;

    /**
     * The section configuration.
     *
     * @var array
     */
    protected $section;

    /**
     * Create a new DefaultFormSection instance.
     *
     * @param Form  $form
     * @param array $section
     */
    function __construct(Form $form, array $section)
    {
        $this->form    = $form;
        $this->section = $section;
    }

    /**
     * Render the section.
     *
     * @return string
     */
    public function render()
    {
        $class = array_get($this->section, 'class', 'panel panel-default');

        $body    = $this->getBody();
        $heading = $this->getHeading();

        return view('ui/form/sections/index', compact('class', 'heading', 'body'));
    }

    protected function getHeading()
    {
        return view('ui/form/sections/default/heading', ['title' => 'TEST']);
    }

    protected function getBody()
    {
        $layout = $this->execute(new BuildFormSectionLayoutCommand($this->form, $this->section));

        $body = view('ui/form/sections/layout', $layout);

        return view('ui/form/sections/default/body', compact('body'));
    }
}
 