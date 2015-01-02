<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Illuminate\Support\Collection;

/**
 * Class ButtonPluginFunctions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui
 */
class ButtonPluginFunctions
{

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
