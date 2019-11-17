<?php

namespace Anomaly\Streams\Platform\Addon\Theme;

use Anomaly\Streams\Platform\Addon\AddonCollection;

/**
 * Class ThemeCollection
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ThemeCollection extends AddonCollection
{

    /**
     * Return the active theme.
     *
     * @param string $type
     * @param bool $instance
     * @return Theme
     */
    public function active($type = null, $instance = true)
    {
        if (!$type) {
            return $this->current($instance);
        }

        return $this->map(function ($addon, $namespace) use ($type, $instance) {

            if ($namespace !== config("streams::themes.{$type}")) {
                return null;
            }

            return $instance ? app($namespace) : $addon;
        })->filter()->first();
    }

    /**
     * Return the current theme.
     *
     * @param bool $instance
     * @return null|Theme
     */
    public function current($instance = true)
    {
        $current = config('streams::themes.current');

        return $this->map(function ($addon, $namespace) use ($current, $instance) {

            if ($namespace !== $current) {
                return null;
            }

            return $instance ? app($namespace) : $addon;
        })->filter()->first();
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
}
