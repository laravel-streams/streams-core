<?php namespace Anomaly\Streams\Platform\Addon\Theme;

use Anomaly\Streams\Platform\Addon\AddonListener;
use Laracasts\Commander\Events\DispatchableTrait;

/**
 * Class ThemeListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Theme
 */
class ThemeListener extends AddonListener
{

    use DispatchableTrait;

    public function whenStreamsIsBooting()
    {
        $this->execute('\Anomaly\Streams\Platform\Addon\Theme\Command\DetectActiveThemeCommand');
    }
}
 