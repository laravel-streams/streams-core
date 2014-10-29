<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\FormSection;

class TabbedFormSection extends FormSection
{

    public function heading()
    {
        return view('html/section/tabbed/heading');
    }

    public function body()
    {
        $body = 'FOO BAR BITCH';

        return view('html/section/tabbed/body', compact('body'));
    }

}
 