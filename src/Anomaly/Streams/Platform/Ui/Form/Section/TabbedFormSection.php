<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\FormSection;

/**
 * Class TabbedFormSection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Section
 */
class TabbedFormSection extends FormSection
{

    /**
     * Return the heading.
     *
     * @return \Illuminate\View\View
     */
    public function heading()
    {
        return view('html/section/tabbed/heading');
    }

    /**
     * Return the body.
     *
     * @return \Illuminate\View\View
     */
    public function body()
    {
        return view('html/section/tabbed/body');
    }

}
 