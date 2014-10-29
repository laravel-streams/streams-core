<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\FormSection;

class DefaultFormSection extends FormSection
{

    public function heading()
    {
        $title = $this->getTitle();

        return view('html/section/default/heading', compact('title'));
    }

    public function body()
    {
        $body = 'FOO BAR BITCH';

        return view('html/section/default/body', compact('body'));
    }

    protected function getTitle()
    {
        return trans(evaluate_key($this->section, 'title', 'misc.untitled'));
    }

}
 