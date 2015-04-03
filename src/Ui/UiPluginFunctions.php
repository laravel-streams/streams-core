<?php namespace Anomaly\Streams\Platform\Ui;

use Anomaly\Streams\Platform\Ui\Icon\IconRegistry;

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
     * The icon registry.
     *
     * @var IconRegistry
     */
    protected $icons;

    /**
     * Create a new UiPluginFunctions instance.
     *
     * @param IconRegistry $icons
     */
    public function __construct(IconRegistry $icons)
    {
        $this->icons = $icons;
    }

    /**
     * Return icon HTML.
     *
     * @param $type
     * @return string
     */
    public function icon($type)
    {
        return '<i class="' . $this->icons->get($type) . ' icon"></i>';
    }

    /**
     * Render buttons.
     *
     * @param $buttons
     * @return \Illuminate\View\View
     */
    public function buttons($buttons)
    {
        return view('streams::buttons/buttons', compact('buttons'));
    }
}
