<?php

namespace Anomaly\Streams\Platform\Addon;

use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Addon\Addon;

/**
 * Class AddonCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonCollection extends Collection
{

    /**
     * Return all addon namespaces.
     *
     * @param  null $key
     * @return array
     */
    public function namespaces($key = null)
    {
        return $this->map(
            function ($item) use ($key) {
                return $item . ($key ? "::{$key}" : null);
            }
        )->all();
    }

    /**
     * Return only core addons.
     *
     * @return AddonCollection
     */
    public function core()
    {
        return $this->filter(
            function ($addon) {

                /* @var Addon $addon */
                return $addon->isCore();
            }
        );
    }

    /**
     * Return only non-core addons.
     *
     * @return AddonCollection
     */
    public function nonCore()
    {
        return $this->filter(
            function ($addon) {

                /* @var Addon $addon */
                return !$addon->isCore();
            }
        );
    }

    /**
     * Return only testing addons.
     *
     * @return AddonCollection
     */
    public function testing()
    {
        $testing = [];

        /* @var Addon $item */
        foreach ($this->items as $item) {
            if ($item->isTesting()) {
                $testing[] = $item;
            }
        }

        return self::make($testing);
    }

    /**
     * Get an addon.
     *
     * @param  mixed $key
     * @param  null $default
     * @return Addon|mixed|null
     */
    public function get($key, $default = null)
    {
        if (!$key) {
            return $default;
        }

        if (!$addon = parent::get($key, $default)) {
            return $this->findBySlug($key);
        }

        return $addon;
    }

    /**
     * Find an addon by it's slug.
     *
     * @param  string $slug
     * @param bool $instance
     *
     * @return null|Addon
     */
    public function findBySlug(string $slug, $instance = true)
    {
        return $this->first(function ($addon, $namespace) use ($slug, $instance) {

            if (!str_is("*.*.{$slug}", $namespace)) {
                return null;
            }

            return $instance ? app($namespace) : $addon;
        });
    }

    /**
     * Order addon's by their slug.
     *
     * @param string $direction
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
     * Disperse addons to their
     * respective collections.
     * 
     * @return $this
     */
    public function disperse()
    {
        foreach (config('streams::addons.types', []) as $type) {

            /* @var AddonCollection $collection */
            $collection = app("{$type}.collection");

            $this->type($type)->each(function ($addon, $namespace) use ($collection) {
                $collection->put($namespace, $addon);
            });
        }

        return $this;
    }

    /**
     * Return addon instances.
     * 
     * @return $this
     */
    public function instances()
    {
        return $this->map(function ($addon, $namespace) {
            return $this->instance($namespace);
        });
    }

    /**
     * Return an addon instance.
     *
     * @param string $addon
     * @return Addon|null
     */
    public function instance($addon)
    {
        if (!isset($this->items[$addon])) {
            return null;
        }

        return app($addon);
    }

    /**
     * Fire the registered
     * method on all addons.
     */
    public function registered()
    {
        $this->map(
            function ($addon) {

                /* @var Addon $addon */
                $addon->fire('registered', compact('addon'));
            }
        );
    }

    /**
     * Return only a certain type.
     *
     * @param string $type
     */
    public function type(string $type)
    {
        return $this->filter(function ($addon, $namespace) use ($type) {
            return str_is("*.{$type}.*", $namespace);
        });
    }

    /**
     * Return addons only with the provided configuration.
     *
     * @param $key
     * @return AddonCollection
     */
    public function withConfig($key)
    {
        $addons = [];

        /* @var Addon $item */
        foreach ($this->items as $item) {
            if ($item->hasConfig($key)) {
                $addons[] = $item;
            }
        }

        return self::make($addons);
    }

    /**
     * Return addons only with any of
     * the provided configuration.
     *
     * @param  array $keys
     * @return AddonCollection
     */
    public function withAnyConfig(array $keys)
    {
        $addons = [];

        /* @var Addon $item */
        foreach ($this->items as $item) {
            if ($item->hasAnyConfig($keys)) {
                $addons[] = $item;
            }
        }

        return self::make($addons);
    }

    /**
     * Sort through each item with a callback.
     *
     * @param  callable|null $callback
     * @return static
     */
    public function sort(callable $callback = null)
    {
        return parent::sort(
            $callback ?: function ($a, $b) {

                /* @var Addon $a */
                /* @var Addon $b */
                if ($a->getSlug() == $b->getSlug()) {
                    return 0;
                }

                return ($a->getSlug() < $b->getSlug()) ? -1 : 1;
            }
        );
    }

    /**
     * Return only installable addons.
     *
     * @return AddonCollection
     */
    public function installable()
    {
        return $this->filter(
            function ($addon) {

                /* @var Addon $addon */
                return in_array($addon->getType(), ['module', 'extension']);
            }
        );
    }

    /**
     * Return enabled addons.
     *
     * @return AddonCollection
     */
    public function enabled()
    {
        return $this->installable()->filter(
            function ($addon) {

                /* @var Module|Extension $addon */
                return $addon->isEnabled();
            }
        );
    }

    /**
     * Return installed addons.
     *
     * @return AddonCollection
     */
    public function installed()
    {
        return $this->installable()->filter(
            function ($addon) {

                /* @var Module|Extension $addon */
                return $addon->isInstalled();
            }
        );
    }

    /**
     * Return uninstalled addons.
     *
     * @return AddonCollection
     */
    public function uninstalled()
    {
        return $this->installable()->filter(
            function ($addon) {

                /* @var Module|Extension $addon */
                return !$addon->isInstalled();
            }
        );
    }

    /**
     * Return loaded addons.
     *
     * @return AddonCollection
     */
    public function loaded()
    {
        return $this->filter(
            function ($addon) {

                /* @var Addon|Module|Extension $addon */
                if (!in_array($addon->getType(), ['module', 'extension'])) {
                    return true;
                }

                return $addon->isInstalled();
            }
        );
    }

    /**
     * Call a method.
     *
     * @param $method
     * @param $arguments
     * @return AddonCollection
     */
    public function __call($method, $arguments)
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
    public function __get($name)
    {
        $type = str_singular($name);

        if (in_array($type, config('streams::addons.types'))) {
            return app("{$type}.collection");
        }

        return $this->{$name};
    }
}
