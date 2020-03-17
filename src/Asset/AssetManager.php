<?php

namespace Anomaly\Streams\Platform\Asset;

use JSMin\JSMin;
use Illuminate\Http\Request;
use Collective\Html\HtmlBuilder;
use tubalmartin\CssMin\Minifier;
use League\Flysystem\MountManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Filesystem\Filesystem;
use Anomaly\Streams\Platform\Support\Template;
use Anomaly\Streams\Platform\Routing\UrlGenerator;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;

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
     * The public base directory.
     *
     * @var null|string
     */
    protected $directory;

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
     * The URL generator.
     *
     * @var UrlGenerator
     */
    protected $url;

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
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The theme collection.
     *
     * @var ThemeCollection
     */
    protected $themes;

    /**
     * The mount manager.
     *
     * @var MountManager
     */
    protected $manager;

    /**
     * The asset registry.
     *
     * @var AssetRegistry
     */
    protected $registry;

    /**
     * The template utility.
     *
     * @var Template
     */
    protected $template;

    /**
     * Create a new Asset instance.
     *
     * @param ThemeCollection $themes
     * @param AssetRegistry $registry
     * @param MountManager $manager
     * @param Template $template
     * @param Filesystem $files
     * @param AssetPaths $paths
     * @param HtmlBuilder $html
     * @param Request $request
     * @param UrlGenerator $url
     */
    public function __construct(
        ThemeCollection $themes,
        AssetRegistry $registry,
        MountManager $manager,
        Template $template,
        Filesystem $files,
        AssetPaths $paths,
        HtmlBuilder $html,
        Request $request,
        UrlGenerator $url
    ) {
        $this->url      = $url;
        $this->html     = $html;
        $this->files    = $files;
        $this->paths    = $paths;
        $this->themes   = $themes;
        $this->request  = $request;
        $this->manager  = $manager;
        $this->registry = $registry;
        $this->template = $template;
    }

    /**
     * Return the collection.
     *
     * @param [type] $name
     */
    public function collection($name)
    {
        if (!$collection = array_get($this->collections, $name)) {
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
    public function resolve($name, $default)
    {
        return $this->registry->resolve($name, $default);
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

        return $this->url->asset($path, $parameters, $secure);
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
            return $this->script($asset);
        } else {
            return $this->style($asset);
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
     * Return the style tag for a collection.
     *
     * @param $collection
     * @param  array $filters
     * @param  array $attributes
     * @return string
     */
    public function style($collection, array $attributes = [])
    {
        $defaults = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];

        $attributes = $attributes + $defaults;

        $attributes['href'] = $this->path($collection);

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
        if (starts_with($asset, ['http', '//'])) {
            return $asset;
        }

        if (!file_exists($file = $this->paths->real($asset))) {
            return null;
        }

        /*
         * If the asset is public just use it.
         */
        if (starts_with($asset, 'public::')) {
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

        if (str_contains($collection, public_path())) {
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

        $path = $this->directory . DIRECTORY_SEPARATOR . $path;

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

        if (starts_with($collection, 'public::')) {
            return false;
        }

        if (starts_with($path, 'http')) {
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
     * Set the public base directory.
     *
     * @param  $directory
     * @return $this
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;

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
