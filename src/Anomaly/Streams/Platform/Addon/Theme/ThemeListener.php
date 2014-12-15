<?php namespace Anomaly\Streams\Platform\Addon\Theme;

use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\EventListener;

/**
 * Class ThemeListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Theme
 */
class ThemeListener extends EventListener
{

    use CommanderTrait;

    /**
     * Fired with the ApplicationServiceProvider starts booting.
     */
    public function whenApplicationIsBooting()
    {
        $this->execute('Anomaly\Streams\Platform\Addon\Theme\Command\DetectActiveThemeCommand');
    }
}
