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
            function ($item, $namespace) use ($key) {
                return $namespace . ($key ? "::{$key}" : null);
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
            function (array $addon) {
                return is_dir(base_path('vendor/' . $addon['name']));
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
            function (array $addon) {
                return !is_dir(base_path('vendor/' . $addon['name']));
            }
        );
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
        if (!$this->has($addon)) {
            return null;
        }

        return app($addon);
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
     * Return only installable addons.
     *
     * @return AddonCollection
     */
    public function installable()
    {
        return $this->filter(
            function (array $addon) {
                return str_is(['*/*-module', '*/*-extension'], $addon['name']);
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
            function (array $addon) {
                return $addon['enabled'];
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
            function (array $addon) {
                return $addon['installed'];
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
            function (array $addon) {
                return !$addon['installed'];
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

        if (in_array($type, config('streams.addons.types', []))) {
            return app("{$type}.collection");
        }

        return $this->{$name};
    }
}
