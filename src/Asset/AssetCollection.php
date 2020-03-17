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
        $name = str_replace('@', '', $name);

        if (in_array($name, $this->loaded)) {
            return $this;
        }

        foreach (app(AssetManager::class)->resolve($name, $default) as $key => $resolved) {

            if (!is_numeric($key)) {
                
                $this->load($name . '.' . $key);

                continue;
            }

            $this->loaded[] = $name;

            $this->add($resolved);
        }
        
        return $this;
    }

    /**
     * Return published URLs.
     *
     * @param array $attributes
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
     * Return output tags.
     *
     * @param array $attributes
     * @return array
     */
    public function tags(array $attributes = [])
    {
        return $this->map(function ($asset) use ($attributes) {
            app(AssetManager::class)->tag($asset, $attributes);
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
            app(AssetManager::class)->script($asset, $attributes);
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
            app(AssetManager::class)->style($asset, $attributes);
        });
    }

    /**
     * Return inline assets.
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
     * Return published paths.
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
