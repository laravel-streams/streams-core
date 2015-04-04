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
     * @return AddonCollection
     */
    public function core()
    {
        $core = [];

        foreach ($this->items as $item) {
            if ($item instanceof Addon && $item->isCore()) {
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
     *
     * @return null|Addon
     */
    public function findBySlug($slug)
    {
        foreach ($this->items as $item) {
            if ($item instanceof Addon && $item->getSlug() == $slug) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Order addon's by their slug.
     *
     * @param  string $direction
     *
     * @return AddonCollection
     */
    public function orderBySlug($direction = 'asc')
    {
        $ordered = [];

        foreach ($this->items as $item) {
            if ($item instanceof Addon) {
                $ordered[$item->getSlug()] = $item;
            }
        }

        if ($direction == 'asc') {
            ksort($ordered);
        } else {
            krsort($ordered);
        }

        return self::make($ordered);
    }

    /**
     * Return only extensions with config
     * matching the given pattern.
     *
     * @param $pattern
     *
     * @return AddonCollection
     */
    public function withConfig($pattern = '*')
    {
        $addons = [];

        foreach ($this->items as $item) {
            if ($item instanceof Addon && config($item->getNamespace($pattern))) {
                $addons[$item->getNamespace()] = $item;
            }
        }

        return self::make($addons);
    }

    /**
     * Return all addon types merged as one.
     *
     * @return AddonCollection
     */
    public function merged()
    {
        $addons = [];

        foreach (config('streams.addon_types') as $type) {
            $addons = array_merge($addons, app("{$type}.collection")->toArray());
        }

        return self::make($addons);
    }

    /**
     * Call a method.
     *
     * @param $method
     * @param $arguments
     * @return AddonCollection
     */
    function __call($method, $arguments)
    {
        $type = str_singular($method);

        if (in_array($type, config('streams.addon_types'))) {
            return app("{$type}.collection");
        }

        return call_user_func_array([$this, $method], $arguments);
    }

    /**
     * Get a property.
     *
     * @param $name
     * @return AddonCollection
     */
    function __get($name)
    {
        $type = str_singular($name);

        if (in_array($type, config('streams.addon_types'))) {
            return app("{$type}.collection");
        }

        return $this->{$name};
    }
}
