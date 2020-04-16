<?php

namespace Anomaly\Streams\Platform\Asset;

use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Asset\Facades\Assets;

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
     * Load a named asset.
     *
     * @param $name
     * @param array $default
     * @return $this
     */
    public function load($name, array $default = [])
    {

        // Strip the @load indicator.
        $name = str_replace('@', '', $name);

        /**
         * Only load named assets once.
         */
        if (in_array($name, $this->loaded)) {
            return $this;
        }

        /**
         * Loop over the resolved assets and 
         */
        foreach (Assets::resolve($name, $default) as $resolved) {

            $this->loaded[] = $name;

            $this->put($resolved, $resolved);
        }

        return $this;
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
        return $this->map(function ($asset) use ($attributes, $secure) {
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
        return $this->map(function ($asset) use ($attributes) {
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
        return $this->map(function ($asset) use ($attributes) {
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
        return $this->map(function ($asset) use ($attributes) {
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
        return $this->map(function ($asset) {
            return Assets::inline($asset);
        });
    }

    /**
     * Return published paths.
     *
     * This instead of combining the collection contents
     * just returns an array of individual processed
     * paths instead.
     *
     * @return $this
     */
    public function paths()
    {
        return $this->map(function ($asset) {
            return Assets::path($asset);
        });
    }

    /**
     * Return the content of a collection.
     *
     * @param $collection
     */
    public function content()
    {
        return $this->inlines()->implode("\n\n");
    }

    /**
     * Return collection as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->implode('');
    }
}
