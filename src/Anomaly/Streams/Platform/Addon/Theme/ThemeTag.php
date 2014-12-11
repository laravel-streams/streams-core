<?php namespace Anomaly\Streams\Platform\Addon\Theme;

use Anomaly\Streams\Platform\Addon\Tag\Tag;

/**
 * Class ThemeTag
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Theme
 */
class ThemeTag extends Tag
{
    /**
     * The theme object.
     *
     * @var Theme
     */
    protected $theme;

    /**
     * Create a new ThemeTag instance.
     *
     * @param Theme $theme
     */
    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * Return the translated theme name.
     *
     * @return string
     */
    public function name()
    {
        return trans($this->theme->getName());
    }

    /**
     * Return the translated theme description.
     *
     * @return string
     */
    public function description()
    {
        return trans($this->theme->getDescription());
    }
}
