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
    public function active($type = null)
    {
        if (!$type) {
            return $this->current();
        }

        $admin = $type == 'standard' ? false : true;

        /* @var Theme $item */
        foreach ($this->items as $item) {
            if ($item->isActive() && $item->isAdmin() === $admin) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return the active standard theme.
     *
     * @return null|Theme
     */
    public function activeStandard()
    {
        return $this
            ->standard()
            ->active();
    }

    /**
     * Return the active admin theme.
     *
     * @return null|Theme
     */
    public function activeAdmin()
    {
        return $this
            ->admin()
            ->active();
    }

    /**
     * Return only non-admin themes.
     *
     * @return ThemeCollection
     */
    public function standard()
    {
        $items = [];

        /* @var Theme $item */
        foreach ($this->items as $item) {
            if (!$item->isAdmin()) {
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

        /* @var Theme $item */
        foreach ($this->items as $item) {
            if ($item->isAdmin()) {
                $items[] = $item;
            }
        }

        return new static($items);
    }

    /**
     * Return the current theme.
     *
     * @return null|Theme
     */
    public function current()
    {
        /* @var Theme $item */
        foreach ($this->items as $item) {
            if ($item->isCurrent()) {
                return $item;
            }
        }

        return null;
    }
}
