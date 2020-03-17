<?php

namespace Anomaly\Streams\Platform\Asset;

use Illuminate\Support\Str;
use Collective\Html\HtmlFacade;
use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Asset\AssetManager;

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
     * Return an array of style URLs.
     *
     * @param  array $filters
     * @param  array $attributes
     * @param null $secure
     * @return array
     */
    public function urls(array $attributes = [], $secure = null)
    {
        return $this->map(function ($asset) use ($attributes, $secure) {
            app(AssetManager::class)->url($asset, $attributes, $secure);
        });
    }

    /**
     * Return an array of script tags.
     *
     * @param  array $attributes
     * @return $this
     */
    public function scripts(array $attributes = [])
    {
        return $this->map(function ($asset) use ($attributes) {
            app(AssetManager::class)->script($asset, $attributes);
        });
    }

    /**
     * Return an array of style tags.
     *
     * @param  array $attributes
     * @return $this
     */
    public function styles(array $attributes = [])
    {
        return $this->map(function ($asset) use ($attributes) {
            app(AssetManager::class)->style($asset, $attributes);
        });
    }

    /**
     * Return an array of inline assets from a collection.
     *
     * Instead of combining the collection contents into a single
     * dump, returns an array of individual processed dumps instead.
     *
     * @return array
     */
    public function inlines()
    {
        return $this->map(function ($asset) {
            app(AssetManager::class)->inline($asset);
        });
    }

    /**
     * Return an array of paths to an asset collection.
     *
     * This instead of combining the collection contents
     * just returns an array of individual processed
     * paths instead.
     *
     * @return array
     */
    public function paths()
    {
        return $this->map(function ($asset) {
            return app(AssetManager::class)->path($asset);
        });
    }

    /**
     * Return the content of a collection.
     *
     * @param $collection
     */
    public function content()
    {
        return join("\n\n", $this->inlines());
    }

    /**
     * Return the collection as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->implode('');
    }
}
