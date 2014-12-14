<?php namespace Anomaly\Streams\Platform\Addon\Theme;

use Anomaly\Streams\Platform\Addon\AddonCollection;

/**
 * Class ThemeCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Theme
 */
class ThemeCollection extends AddonCollection
{
    /**
     * Return the active theme.
     *
     * @return null
     */
    public function active()
    {
        foreach ($this->items as $item) {
            if ($this->themeIsActive($item)) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return whether the theme is active or not.
     *
     * @param Theme $item
     * @return bool
     */
    protected function themeIsActive(Theme $item)
    {
        return $item->isActive();
    }
}
