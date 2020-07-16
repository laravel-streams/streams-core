<?php

namespace Anomaly\Streams\Platform\Asset;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
     * Loaded provisions. When tagging
     * assets using "as:*" they will be
     * added to the loaded array.
     *
     * @var array
     */
    protected $loaded = [];

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

    /**
     * Register assets by name.
     *
     * @param string $name
     * @param string|array $assets
     * @return $this
     */
    public function register($name, $assets)
    {
        $this->registry->register($name, $assets);

        return $this;
    }

    /**
     * Resolve named assets.
     *
     * @param string $name
     * @param string|array $assets
     * @return $this
     */
    public function resolve($name)
    {
        return $this->registry->resolve($name);
    }

    /**
     * Return the contents of a collection.
     *
     * @param $asset
     * @param  array $filters
     * @return string
     */
    public function inline($asset)
    {
        return file_get_contents(
            $this->paths->real('public::' . ltrim($this->path($asset), '/\\'))
        );
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
        if (!$path = $this->path($asset)) {
            return null;
        }

        return URL::asset($path, $parameters, $secure);
    }

    /**
     * Return the tag for an asset.
     *
     * @param string $asset
     * @param array $attributes
     */
    public function tag($asset, array $attributes = [])
    {
        if ($this->paths->extension($asset) == 'js') {
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
     * @return string
     */
    public function script($asset, array $attributes = [])
    {
        $attributes['src'] = $this->path($asset);

        return '<script' . $this->html->attributes($attributes) . '></script>';
    }

    /**
     * Return the style tag for an asset.
     *
     * @param $asset
     * @param  array $attributes
     * @return string
     */
    public function style($asset, array $attributes = [])
    {
        $defaults = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];

        $attributes = $attributes + $defaults;

        $attributes['href'] = $this->path($asset);

        return '<link' . $this->html->attributes($attributes) . '>';
    }

    /**
     * @param $path
     * @return string
     */
    public function path($asset)
    {
        /*
         * If the asset is remote just return it.
         */
        if (Str::startsWith($asset, ['http', '//'])) {
            return $asset;
        }

        if (!file_exists($file = $this->paths->real($asset))) {
            return null;
        }

        /*
         * If the asset is public just use it.
         */
        if (Str::startsWith($asset, 'public::')) {
            return $this->paths->outputPath($file);
        }

        $path = $this->paths->outputPath($asset);

        if ($this->shouldPublish($path, $asset)) {
            $this->publish($path, $asset);
        }

        $path .= '?v=' . filemtime(public_path(trim($path, '/\\')));

        return $path;
    }

    /**
     * Publish the collection of assets to the path.
     *
     * @param $path
     * @param $collection
     */
    protected function publish($path, $collection)
    {
        $path = ltrim($path, '/\\');

        if (Str::contains($collection, public_path())) {
            return;
        }

        /**
         * Get the concatenated content
         * of the asset collection.
         */
        $contents = $this->collection($collection)->content();

        // if (in_array('min', $filters) && $hint == 'css') {
        //     $compressor = new Minifier;

        //     $compressor->setLineBreakPosition(0);
        //     $compressor->removeImportantComments();
        //     $compressor->keepSourceMapComment(false);

        //     $contents = $compressor->run($contents);
        // }

        // if (in_array('min', $filters) && $hint == 'js') {
        //     $contents = JSMin::minify($contents);
        // }

        $path = public_path($path);

        $this->files->makeDirectory((new \SplFileInfo($path))->getPath(), 0755, true, true);

        /**
         * Save the processed content.
         */
        $this->files->put($path, $contents);
    }

    /**
     * Decide whether we need to publish the file
     * to the path or not.
     *
     * @param $path
     * @param $collection
     * @return bool
     */
    protected function shouldPublish($path, $collection)
    {
        $path = ltrim($path, '/\\');

        if (Str::startsWith($collection, 'public::')) {
            return false;
        }

        if (Str::startsWith($path, 'http')) {
            return false;
        }

        if (!$this->files->exists($path)) {
            return true;
        }

        return false;
    }

    /**
     * Add a namespace path hint.
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
     * @param $path
     * @return string
     */
    public function real($asset)
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
