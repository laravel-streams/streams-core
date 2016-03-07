<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Plugin\PluginCollection;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Illuminate\Support\Collection;

/**
 * Class AddonCollection
 *
 * @method ExtensionCollection extensions();
 * @method FieldTypeCollection fieldTypes();
 * @method ModuleCollection modules();
 * @method PluginCollection plugins();
 * @method ThemeCollection themes();
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
        foreach ($items as $key => $item) {

            if ($item instanceof Addon) {
                $key = $item->getNamespace();
            }

            $this->items[$key] = $item;
        }
    }

    /**
     * Return all addon namespaces.
     *
     * @param null $key
     * @return array
     */
    public function namespaces($key = null)
    {
        return array_values(
            $this->map(
                function (Addon $addon) use ($key) {
                    return $addon->getNamespace($key);
                }
            )->all()
        );
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
     * @param mixed $key
     * @param null  $default
     * @return Addon|mixed|null
     */
    public function get($key, $default = null)
    {
        if (!$addon = parent::get($key, $default)) {
            return $this->findBySlug($key);
        }

        return $addon;
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
     * Disperse addons to their
     * respective collections.
     */
    public function disperse()
    {
        foreach (config('streams::addons.types') as $type) {

            /* @var AddonCollection $collection */
            $collection = app("{$type}.collection");

            /* @var Addon $addon */
            foreach ($this->items as $addon) {

                if ($addon->getType() !== $type) {
                    continue;
                }

                $collection->put($addon->getNamespace(), $addon);
            }
        }
    }

    /**
     * Fire the registered
     * method on all addons.
     */
    public function registered()
    {
        $this->map(
            function (Addon $addon) {
                $addon->fire('registered');
            }
        );
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
     * @param array $keys
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
