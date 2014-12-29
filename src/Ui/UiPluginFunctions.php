<?php namespace Anomaly\Streams\Platform\Ui;

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
     * Return icon HTML.
     *
     * @param $type
     * @return string
     */
    public function icon($type)
    {
        return '<i class="fa fa-' . $type . '"></i>';
    }
}
