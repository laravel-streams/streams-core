<?php namespace Anomaly\Streams\Platform\Addon\Theme\Listener;

use Anomaly\Streams\Platform\Addon\Theme\Event\ThemeWasRegistered;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;

/**
 * Class PutThemeInCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Theme\Listener
 */
class PutThemeInCollection
{

    /**
     * The theme collection.
     *
     * @var ThemeCollection
     */
    protected $themes;

    /**
     * Create a new PutThemeInCollection instance.
     *
     * @param ThemeCollection $themes
     */
    public function __construct(ThemeCollection $themes)
    {
        $this->themes = $themes;
    }

    /**
     * Handle the event.
     *
     * @param ThemeWasRegistered $event
     */
    public function handle(ThemeWasRegistered $event)
    {
        $theme = $event->getTheme();
        
        $this->themes->put(get_class($theme), $theme);
    }
}
