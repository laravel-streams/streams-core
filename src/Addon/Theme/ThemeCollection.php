<?php namespace Anomaly\Streams\Platform\Addon\Theme;

use Anomaly\Streams\Platform\Addon\AddonCollection;

/**
 * Class ThemeCollection
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Theme
 */
class ThemeCollection extends AddonCollection
{

    /**
     * Return the active theme.
     *
     * @return Theme
     */
    public function active()
    {
        foreach ($this->items as $item) {
            if ($item instanceof Theme && $item->isActive()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return only non-admin themes.
     *
     * @return ThemeCollection
     */
    public function regular()
    {
        $items = [];

        foreach ($this->items as $item) {
            if ($item instanceof Theme && !$item->isAdmin()) {
                $items[] = $item;
            }
        }

        return new static($items);
    }

    /**
     * Return only admin themes.
     *
     * @return ThemeCollection
     */
    public function admin()
    {
        $items = [];

        foreach ($this->items as $item) {
            if ($item instanceof Theme && $item->isAdmin()) {
                $items[] = $item;
            }
        }

        return new static($items);
    }
}
