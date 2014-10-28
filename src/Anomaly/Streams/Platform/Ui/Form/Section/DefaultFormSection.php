<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\FormSection;

class DefaultFormSection extends FormSection
{

    public function heading()
    {
        $title = $this->getTitle();

        $data = compact('title');

        return view('html/form/default_section/heading', $data);
    }

    protected function getTitle()
    {
        return trans(evaluate_key($this->section, 'title', 'misc.untitled'));
    }

}
 