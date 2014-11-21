<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Ui\Form\Command\BuildFormSectionLayoutCommand;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormSectionInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class TabbedFormSection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Section
 */
class TabbedFormSection implements FormSectionInterface
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
        $tabs = $this->getTabs();

        $class = array_get($this->section, 'class', 'panel panel-default');

        return view('ui/form/sections/tabbed/index', compact('class', 'tabs'));
    }

    /**
     * Get the tabs.
     *
     * @return array
     */
    protected function getTabs()
    {
        $tabs = [];

        $expander = $this->form->getExpander();

        foreach ($this->section['tabs'] as $slug => $tab) {

            $section = $expander->expandLayout($tab);

            $layout = $this->execute(new BuildFormSectionLayoutCommand($this->form, $section));

            $id = $slug;

            $title = array_get($tab, 'title', 'misc.untitled');

            $active = array_search($slug, array_keys($this->section['tabs'])) == 0;

            $body = view('ui/form/sections/layout', $layout);

            $tabs[] = compact('title', 'body', 'active', 'id');
        }

        return $tabs;
    }
}
 