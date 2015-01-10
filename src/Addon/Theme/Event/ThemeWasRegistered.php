<?php namespace Anomaly\Streams\Platform\Addon\Theme\Event;

use Anomaly\Streams\Platform\Addon\Theme\Theme;

/**
 * Class ThemeWasRegistered
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Theme\Event
 */
class ThemeWasRegistered
{

    /**
     * The theme object.
     *
     * @var Theme
     */
    protected $theme;

    /**
     * Create a new ThemeWasRegistered instance.
     *
     * @param Theme $theme
     */
    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * Get the theme object.
     *
     * @return Theme
     */
    public function getTheme()
    {
        return $this->theme;
    }
}
