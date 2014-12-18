<?php namespace Anomaly\Streams\Platform\Addon;

use Illuminate\Support\Collection;

/**
 * Class AddonCollection
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon
 */
class AddonCollection extends Collection
{

    /**
     * Return only core addons.
     *
     * @return static
     */
    public function core()
    {
        $core = [];

        foreach ($this->items as $item) {
            if ($item->isCore()) {
                $core[] = $item;
            }
        }

        return self::make($core);
    }

    /**
     * Push an addon to the collection.
     *
     * @param mixed $addon
     */
    public function push($addon)
    {
        if ($addon instanceof Addon) {
            $this->items[$addon->getSlug()] = $addon;
        }
    }

    /**
     * Find an addon by it's slug.
     *
     * @param  $slug
     * @return null
     */
    public function findBySlug($slug)
    {
        if (isset($this->items[$slug])) {
            return $this->items[$slug];
        }

        return null;
    }

    /**
     * Order addon's by their name.
     *
     * @param  string $direction
     * @return static
     */
    public function orderByName($direction = 'asc')
    {
        $ordered = [];

        foreach ($this->items as $item) {
            $ordered[trans($item->getName())] = $item;
        }

        if ($direction == 'asc') {
            ksort($ordered);
        } else {
            krsort($ordered);
        }

        return self::make($ordered);
    }
}
