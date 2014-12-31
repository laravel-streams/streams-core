<?php namespace Anomaly\Streams\Platform\Ui;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
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
     * Return a button.
     *
     * @param ButtonInterface $button
     */
    public function button(ButtonInterface $button)
    {
        if ($button->getTag() == 'a') {
            return $this->html->link($button->getUrl(), trans($button->getText()), $button->getAttributes());
        }

        if ($button->getTag() == 'button') {
            //return $this->form->button()
        }
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
