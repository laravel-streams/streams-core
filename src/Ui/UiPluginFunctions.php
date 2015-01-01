<?php namespace Anomaly\Streams\Platform\Ui;

use Illuminate\Html\FormBuilder;
use Illuminate\Html\HtmlBuilder;
use Illuminate\Support\Collection;

/**
 * Class UiPluginFunctions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui
 */
class UiPluginFunctions
{

    /**
     * The HTML builder.
     *
     * @var \Illuminate\Html\HtmlBuilder
     */
    protected $html;

    /**
     * The form builder.
     *
     * @var \Illuminate\Html\FormBuilder
     */
    protected $form;

    /**
     * Create a new UiPluginFunctions instance.
     *
     * @param FormBuilder $form
     * @param HtmlBuilder $html
     */
    function __construct(FormBuilder $form, HtmlBuilder $html)
    {
        $this->form = $form;
        $this->html = $html;
    }

    /**
     * Return icon HTML.
     *
     * @param $type
     * @return string
     */
    public function icon($type)
    {
        return '<i class="fa fa-' . $type . '"></i>';
    }

    /**
     * Render buttons.
     *
     * @param Collection $buttons
     * @return \Illuminate\View\View
     */
    public function buttons(Collection $buttons)
    {
        return view('streams::ui/button/buttons', compact('buttons'));
    }
}
