<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormSectionInterface;
use Anomaly\Streams\Platform\Ui\Form\FormSection;

/**
 * Class TabbedFormSection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Section
 */
class TabbedFormSection extends FormSection implements FormSectionInterface
{

    /**
     * Return the heading.
     *
     * @return \Illuminate\View\View
     */
    public function heading()
    {
        foreach ($this->section['tabs'] as $k => &$tab) {

            $tab['id']     = $k;
            $tab['active'] = $k == 0 ? 'active' : null;
            $tab['title']  = trans(evaluate_key($tab, 'title', 'misc.untitled'));

            unset($tab['body']);
        }

        return view('ui/form/sections/tabbed/heading', $this->section);
    }

    /**
     * Return the body.
     *
     * @return \Illuminate\View\View
     */
    public function body()
    {

        foreach ($this->section['tabs'] as $k => &$tab) {

            $tab['layout'] = $this->getLayout($tab);

            $tab['id']     = $k;
            $tab['body']   = $this->getBody($tab['layout']);
            $tab['active'] = $k == 0 ? 'active' : null;
        }

        return view('ui/form/sections/tabbed/body', $this->section);
    }

    /**
     * Get the body.
     *
     * @return \Illuminate\View\View
     */
    protected function getBody($layout)
    {
        return view('ui/form/sections/layout', compact('layout'));
    }
}
 