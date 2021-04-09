<?php

namespace Streams\Core\Asset;

use Illuminate\Support\Arr;
use Collective\Html\HtmlBuilder;
use Illuminate\Support\Facades\URL;
use Illuminate\Filesystem\Filesystem;

/**
 * Class AssetManager
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AssetManager
{

    /**
     * Groups of assets. Groups can
     * be single files as well.
     *
     * @var array
     */
    protected $collections = [];

    /**
     * Resolved assets.
     *
     * @var array
     */
    protected $resolved = [];

    /**
     * The HTML utility.
     *
     * @var HtmlBuilder
     */
    protected $html;

    /**
     * The files system.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Asset path hints by namespace.
     *
     * 'module.users' => 'the/resources/path'
     *
     * @var AssetPaths
     */
    protected $paths;

    /**
     * The asset registry.
     *
     * @var AssetRegistry
     */
    protected $registry;

    /**
     * Create a new Asset instance.
     *
     * @param AssetRegistry $registry
     * @param Filesystem $files
     * @param AssetPaths $paths
     * @param HtmlBuilder $html
     */
    public function __construct(
        AssetRegistry $registry,
        Filesystem $files,
        AssetPaths $paths,
        HtmlBuilder $html
    ) {
        $this->html     = $html;
        $this->files    = $files;
        $this->paths    = $paths;
        $this->registry = $registry;
    }

    /**
     * Return the collection.
     *
     * @param string $name
     */
    public function collection($name)
    {
        if (!$collection = Arr::get($this->collections, $name)) {
            $this->collections[$name] = $collection = new AssetCollection();
        }

        return $collection;
    }

    public function add($collection, $asset)
    {
        $this->collection($collection)->add($asset);
    }

    public function load($collection, $asset)
    {
        $this->collection($collection)->load($asset);
    }

    /**
     * Register assets by name.
     *
     * @param string $name
     * @param string|array $assets
     * @return $this
     */
    public function register($name, $assets = null)
    {
        $assets = $assets ?: $name;

        $this->registry->register($name, $assets);

        return $this;
    }

    /**
     * Return the contents of an asset.
     *
     * @param $asset
     * @param  array $filters
     * @return string
     */
    public function inline($asset)
    {
        $asset = $this->resolve($asset);

        if (!filter_var($asset, FILTER_VALIDATE_URL)) {
            $asset = public_path(ltrim($asset, '/\\'));
        }

        $contents = file_get_contents($asset);

        if (pathinfo($asset, PATHINFO_EXTENSION) == 'js') {
            return $this->script(null, [], $contents);
        }

        return $this->style(null, [], $contents);
    }

    /**
     * Return the contents of an asset.
     *
     * @param $asset
     * @param  array $filters
     * @return string
     */
    public function contents($asset)
    {
        $asset = $this->resolve($asset);

        if (!filter_var($asset, FILTER_VALIDATE_URL)) {
            $asset = public_path(ltrim($asset, '/\\'));
        }

        return file_get_contents($asset);
    }

    /**
     * Return the URL to a compiled asset collection.
     *
     * @param string $asset
     * @param array $parameters
     * @param boolean $secure
     */
    public function url($asset, array $parameters = [], $secure = null)
    {
        return URL::to($this->resolve($asset), $parameters, $secure);
    }

    /**
     * Return the tag for an asset.
     *
     * @param string $asset
     * @param array $attributes
     */
    public function tag($asset, array $attributes = [])
    {
        $asset = $this->resolve($asset);

        if (pathinfo($asset, PATHINFO_EXTENSION) == 'js') {
            return $this->script($asset, $attributes);
        } else {
            return $this->style($asset, $attributes);
        }
    }

    /**
     * Return the script tag for a collection.
     *
     * @param $collection
     * @param  array $filters
     * @param  array $attributes
     * @param  $content
     * @return string
     */
    public function script($asset, array $attributes = [], $content = null)
    {
        if (!$content) {
            $attributes['src'] = $this->resolve($asset);
        }

        if (
            isset($attributes['src'])
            && $attributes['src'] === basename($attributes['src'])
        ) {
            $attributes['src'] = '/' . $attributes['src'];
        }

        return '<script' . $this->html->attributes($attributes) . '>' . $content . '</script>';
    }

    /**
     * Return the style tag for an asset.
     *
     * @param $asset
     * @param  array $attributes
     * @param  $content
     * @return string
     */
    public function style($asset, array $attributes = [], $content = null)
    {
        $defaults = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];

        $attributes = $attributes + $defaults;

        if ($content) {
            return '<style' . $this->html->attributes($attributes) . '>' . $content . '</style>';
        }

        if (!$content) {
            $attributes['href'] = $this->resolve($asset);
        }

        if (
            isset($attributes['href'])
            && $attributes['href'] === basename($attributes['href'])
        ) {
            $attributes['href'] = '/' . $attributes['href'];
        }

        return '<link' . $this->html->attributes($attributes) . '/>';
    }

    /**
     * Resolve an asset.
     *
     * @param string $asset
     * @return $this
     */
    public function resolve($asset)
    {
        if (isset($this->resolved[$asset])) {
            return $this->resolved[$asset];
        }

        if (filter_var($asset, FILTER_VALIDATE_URL)) {
            return $asset;
        }

        $resolved = $this->registry->resolve($asset);

        if (is_array($resolved)) {
            return $this->resolved[$asset] = array_map(function ($asset) {
                return $this->realPath($asset);
            }, $resolved);
        }

        return $this->realPath($resolved);
    }

    /**
     * Add a namespace asset hint.
     *
     * @param  $namespace
     * @param  $path
     * @return $this
     */
    public function addPath($namespace, $path)
    {
        $this->paths->addPath($namespace, $path);

        return $this;
    }

    /**
     * Return the real path
     * for a prefixed one.
     *
     * @param $asset
     * @return string
     */
    public function realPath($asset)
    {
        return $this->paths->real($asset);
    }

    /**
     * Return object as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return '';
    }
}
