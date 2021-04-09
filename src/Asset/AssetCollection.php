<?php

namespace Streams\Core\Asset;

use Illuminate\Support\Collection;
use Streams\Core\Support\Facades\Assets;

/**
 * Class AssetCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AssetCollection extends Collection
{

    /**
     * The loaded assets.
     *
     * @var array
     */
    private $loaded = [];

    /**
     * Add an item to the collection.
     * 
     * To avoid duplicates we simply
     * override this method to prevent
     * this kind of addition to assets.
     *
     * @param  $asset
     */
    public function add($asset)
    {
        $this->put($asset, $asset);
    }

    /**
     * Load a named asset.
     *
     * @param $name
     * @param array $default
     * @return $this
     */
    public function load($name)
    {
        if (isset($this->loaded[$name])) {
            return $this;
        }

        $resolved = (array) Assets::resolve($name);

        foreach ($resolved as $asset) {

            $this->loaded[$name] = $name;

            $this->put($asset, $asset);
        }

        return $this;
    }

    /**
     * Return resolved assets.
     *
     * @return $this
     */
    public function resolved()
    {
        return $this->map(function (&$asset) {
            return Assets::resolve($asset);
        });
    }

    /**
     * Return published URLs.
     *
     * @param array $attributes
     * @param null $secure
     * @return $this
     */
    public function urls(array $attributes = [], $secure = null)
    {
        return $this->resolved()->map(function ($asset) use ($attributes, $secure) {
            return Assets::url($asset, $attributes, $secure);
        });
    }

    /**
     * Return output tags.
     *
     * @param array $attributes
     * @return $this
     */
    public function tags(array $attributes = [])
    {
        return $this->resolved()->map(function ($asset) use ($attributes) {
            return Assets::tag($asset, $attributes);
        });
    }

    /**
     * Return script tags.
     *
     * @param  array $attributes
     * @return $this
     */
    public function scripts(array $attributes = [])
    {
        return $this->resolved()->map(function ($asset) use ($attributes) {
            return Assets::script($asset, $attributes);
        });
    }

    /**
     * Return style tags.
     *
     * @param  array $attributes
     * @return $this
     */
    public function styles(array $attributes = [])
    {
        return $this->resolved()->map(function ($asset) use ($attributes) {
            return Assets::style($asset, $attributes);
        });
    }

    /**
     * Return inline assets.
     *
     * @return $this
     */
    public function inlines()
    {
        return $this->resolved()->map(function ($asset) {
            return Assets::inline($asset);
        });
    }

    /**
     * Return the content of a collection.
     *
     * @param $collection
     * @return $this
     */
    public function content()
    {
        return $this->resolved()->map(function ($asset) {
            return Assets::contents($asset);
        });
    }

    /**
     * Return collection as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return implode("\n", $this->items);
    }
}
