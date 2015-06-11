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
     * Create a new AddonCollection instance.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        /* @var Addon $item */
        foreach ($items as $item) {
            $this->items[$item->getNamespace()] = $item;
        }
    }

    /**
     * Return only core addons.
     *
     * @return AddonCollection
     */
    public function core()
    {
        $core = [];

        /* @var Addon $item */
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
        /* @var Addon $addon */
        $this->items[$addon->getNamespace()] = $addon;
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
        /* @var Addon $item */
        foreach ($this->items as $item) {
            if ($item->getSlug() == $slug) {
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

        /* @var Addon $item */
        foreach ($this->items as $item) {
            $ordered[$item->getNamespace()] = $item;
        }

        if ($direction == 'asc') {
            ksort($ordered);
        } else {
            krsort($ordered);
        }

        return self::make($ordered);
    }

    /**
     * Return all addon types merged as one.
     *
     * @return AddonCollection
     */
    public function merged()
    {
        $addons = [];

        foreach (config('streams::addons.types') as $type) {

            /* @var Addon $addon */
            foreach (app("{$type}.collection") as $addon) {
                $addons[$addon->getNamespace()] = $addon;
            }
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

        if (in_array($type, config('streams::addons.types'))) {
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

        if (in_array($type, config('streams::addons.types'))) {
            return app("{$type}.collection");
        }

        return $this->{$name};
    }
}
