<?php namespace Anomaly\Streams\Platform\Asset;

use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Asset\Filter\CoffeeFilter;
use Anomaly\Streams\Platform\Asset\Filter\CssMinFilter;
use Anomaly\Streams\Platform\Asset\Filter\JsMinFilter;
use Anomaly\Streams\Platform\Asset\Filter\LessFilter;
use Anomaly\Streams\Platform\Asset\Filter\ParseFilter;
use Anomaly\Streams\Platform\Asset\Filter\ScssFilter;
use Anomaly\Streams\Platform\Asset\Filter\SeparatorFilter;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;
use Assetic\Filter\PhpCssEmbedFilter;
use Collective\Html\HtmlBuilder;
use Illuminate\Filesystem\Filesystem;
use League\Flysystem\MountManager;

/**
 * Class Asset
 *
 * This is the asset management class. It handles front
 * and backend asset's for everything.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Asset
 */
class Asset
{

    /**
     * The public base directory.
     *
     * @var null
     */
    protected $directory = null;

    /**
     * If true force publishing.
     *
     * @var bool
     */
    protected $publish = false;

    /**
     * Groups of assets. Groups can
     * be single files as well.
     *
     * @var array
     */
    protected $collections = [];

    /**
     * The HTML utility.
     *
     * @var HtmlBuilder
     */
    protected $html;

    /**
     * Asset path hints by namespace.
     *
     * 'module.users' => 'the/resources/path'
     *
     * @var AssetPaths
     */
    protected $paths;

    /**
     * The asset parser utility.
     *
     * @var AssetParser
     */
    protected $parser;

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
     * The stream application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new Application instance.
     *
     * @param Application     $application
     * @param ThemeCollection $themes
     * @param MountManager    $manager
     * @param AssetPaths      $paths
     * @param AssetParser     $parser
     * @param HtmlBuilder     $html
     */
    public function __construct(
        Application $application,
        ThemeCollection $themes,
        MountManager $manager,
        AssetPaths $paths,
        AssetParser $parser,
        HtmlBuilder $html
    ) {
        $this->html        = $html;
        $this->paths       = $paths;
        $this->themes      = $themes;
        $this->parser      = $parser;
        $this->manager     = $manager;
        $this->application = $application;
    }

    /**
     * Add an asset or glob pattern to an asset collection.
     *
     * This should support the asset being the collection
     * and the asset (for single files) internally
     * so asset.links / asset.scripts will work.
     *
     * @param       $collection
     * @param       $file
     * @param array $filters
     * @return $this
     * @throws \Exception
     */
    public function add($collection, $file, array $filters = [])
    {
        if (!isset($this->collections[$collection])) {
            $this->collections[$collection] = [];
        }

        $filters = $this->addConvenientFilters($file, $filters);

        $file = $this->paths->realPath($file);

        /**
         * If this is a remote or single existing
         * file then add it normally.
         */
        if (starts_with($file, ['http', '//']) || file_exists($file)) {

            $this->collections[$collection][$file] = $filters;

            return $this;
        }

        /**
         * If this is a valid glob pattern then add
         * it to the collection and add the glob filter.
         */
        if (count(glob($file)) > 0) {

            $this->collections[$collection][$file] = array_merge($filters, ['glob']);

            return $this;
        }

        if (config('app.debug')) {
            throw new \Exception("Asset [{$file}] does not exist!");
        }
    }

    /**
     * Return the URL to a compiled asset collection.
     *
     * @param        $collection
     * @param  array $filters
     * @return string
     */
    public function url($collection, array $filters = [])
    {
        if (!isset($this->collections[$collection])) {
            $this->add($collection, $collection, $filters);
        }

        return url($this->getPath($collection, $filters));
    }

    /**
     * Return the path to a compiled asset collection.
     *
     * @param        $collection
     * @param  array $filters
     * @return string
     */
    public function path($collection, array $filters = [])
    {
        if (!isset($this->collections[$collection])) {
            $this->add($collection, $collection, $filters);
        }

        return $this->getPath($collection, $filters);
    }

    /**
     * Return the script tag for a collection.
     *
     * @param       $collection
     * @param array $filters
     * @param array $attributes
     * @return string
     */
    public function script($collection, array $filters = [], array $attributes = [])
    {
        return $this->html->script($this->path($collection, $filters), $attributes);
    }

    /**
     * Return the style tag for a collection.
     *
     * @param       $collection
     * @param array $filters
     * @param array $attributes
     * @return string
     */
    public function style($collection, array $filters = [], array $attributes = [])
    {
        return $this->html->style($this->path($collection, $filters), $attributes);
    }

    /**
     * Return an array of script tags.
     *
     * @param       $collection
     * @param array $filters
     * @return array
     */
    public function scripts($collection, array $filters = [])
    {
        return array_map(
            function ($path) {
                return $this->html->script($path);
            },
            $this->paths($collection, $filters)
        );
    }

    /**
     * Return an array of style tags.
     *
     * @param       $collection
     * @param array $filters
     * @return array
     */
    public function styles($collection, array $filters = [])
    {
        return array_map(
            function ($path) {
                return $this->html->style($path);
            },
            $this->paths($collection, $filters)
        );
    }

    /**
     * Return an array of paths to an asset collection.
     *
     * This instead of combining the collection contents
     * just returns an array of individual processed
     * paths instead.
     *
     * @param        $collection
     * @param  array $additionalFilters
     * @return array
     */
    public function paths($collection, array $additionalFilters = [])
    {
        if (!isset($this->collections[$collection])) {
            return [];
        }

        return array_filter(
            array_map(
                function ($file, $filters) use ($additionalFilters) {

                    $filters = array_filter(array_unique(array_merge($filters, $additionalFilters)));

                    return $this->path($file, $filters);
                },
                array_keys($this->collections[$collection]),
                array_values($this->collections[$collection])
            )
        );
    }

    /**
     * @param $collection
     * @param $filters
     * @return string
     */
    protected function getPath($collection, $filters)
    {
        /**
         * If the asset is remote just return it.
         */
        if (starts_with($collection, 'http')) {
            return $collection;
        }

        $path = $this->getPublicPath($collection, $filters);

        if ($this->shouldPublish($path, $collection, $filters)) {
            $this->publish($path, $collection, $filters);
        }

        return $path;
    }

    /**
     * Get the public path.
     *
     * @param  $collection
     * @param  $filters
     * @return string
     */
    protected function getPublicPath($collection, $filters)
    {
        if (str_contains($collection, public_path())) {
            return ltrim(str_replace(public_path(), '', $collection), '/');
        }

        $hash = $this->hashCollection($collection, $filters);

        $hint = $this->getHint($collection);

        return 'assets/' . $this->application->getReference() . '/cache/' . $hash . '.' . $hint;
    }

    /**
     * Publish the collection of assets to the path.
     *
     * @param $path
     * @param $collection
     * @param $additionalFilters
     */
    protected function publish($path, $collection, $additionalFilters)
    {
        if (str_contains($collection, public_path())) {
            return;
        }

        $assets = new AssetCollection();

        $hint = $this->getHint($collection);

        foreach ($this->collections[$collection] as $file => $filters) {

            $filters = array_filter(array_unique(array_merge($filters, $additionalFilters)));

            $filters = $this->transformFilters($filters, $hint);

            if (in_array('glob', $filters)) {

                unset($filters[array_search('glob', $filters)]);

                $file = new GlobAsset($file, $filters);
            } else {
                $file = new FileAsset($file, $filters);
            }

            $assets->add($file);
        }

        $path = $this->directory . $path;

        /* @var Filesystem $files */
        $files = app('files');

        $files->makeDirectory((new \SplFileInfo($path))->getPath(), 0777, true, true);

        $files->put($path, $assets->dump());

        if ($this->getExtension($path) == 'css') {
            $files->put($path, app('twig')->render(str_replace($this->directory, 'assets::', $path)));
        }
    }

    /**
     * Transform an array of filters to
     * an array of Assetic filters.
     *
     * @param  $filters
     * @param  $hint
     * @return mixed
     */
    protected function transformFilters($filters, $hint)
    {
        foreach ($filters as $k => &$filter) {
            switch ($filter) {
                case 'parse':
                    $filter = new ParseFilter($this->parser);
                    break;

                case 'less':
                    $filter = new LessFilter($this->parser);
                    break;

                case 'scss':
                    $filter = new ScssFilter($this->parser);
                    break;

                case 'coffee':
                    $filter = new CoffeeFilter($this->parser);
                    break;

                case 'embed':
                    $filter = new PhpCssEmbedFilter();
                    break;

                case 'min':
                    if ($hint == 'js') {
                        $filter = new JsMinFilter();
                    } elseif ($hint == 'css') {
                        $filter = new CssMinFilter();
                    }
                    break;

                // Allow these through.
                case 'glob':
                    break;

                default:
                    unset($filters[$k]);
                    break;
            }
        }

        if ($hint == 'js') {
            $filters[] = new SeparatorFilter();
        }

        return $filters;
    }

    /**
     * Add filters that we can assume based
     * on the asset's file name.
     *
     * @param  $file
     * @param  $filters
     * @return array
     */
    protected function addConvenientFilters($file, $filters)
    {
        if (ends_with($file, '.less')) {
            $filters[] = 'less';
        }

        if (ends_with($file, '.scss')) {
            $filters[] = 'scss';
        }

        if (ends_with($file, '.coffee')) {
            $filters[] = 'coffee';
        }

        return array_unique($filters);
    }

    /**
     * Get the extension of a path.
     *
     * @param  $path
     * @return mixed
     */
    protected function getExtension($path)
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    /**
     * Get the compile hint from a path.
     * Group names MUST contain either a
     * JS / CSS extension to hint at what
     * to do with some automation.
     *
     * @param  $path
     * @return mixed|string
     */
    public function getHint($path)
    {
        $hint = $this->getExtension($path);

        if (in_array($hint, ['less', 'scss'])) {
            $hint = 'css';
        }

        if ($hint == 'coffee') {
            $hint = 'js';
        }

        return $hint;
    }

    /**
     * Decide whether we need to publish the file
     * to the path or not.
     *
     * @param        $path
     * @param        $collection
     * @param  array $filters
     * @return bool
     */
    protected function shouldPublish($path, $collection, array $filters = [])
    {
        if (starts_with($path, 'http')) {
            return false;
        }

        if (isset($_GET['_publish'])) {
            return true;
        }

        if ($this->publish === true) {
            return true;
        }

        if (!file_exists($path)) {
            return true;
        }

        // Merge filters from collection files.
        foreach ($this->collections[$collection] as $fileFilters) {
            $filters = array_filter(array_unique(array_merge($filters, $fileFilters)));
        }

        if (in_array('live', $filters)) {
            return true;
        }

        if (in_array('debug', $filters) && config('app.debug')) {
            return true;
        }

        return false;
    }

    /**
     * Hash the collection.
     *
     * This hashes the files in a way so that the
     * computer's base directory path does not affect
     * the file name. This makes it easier to distribute
     * built assets.
     *
     * @param $collection
     * @param $filters
     * @return string
     */
    protected function hashCollection($collection, $filters)
    {
        $key = [];

        foreach ($this->collections[$collection] as $file => $filters) {

            if ($debug = array_search('debug', $filters)) {
                unset($filters[$debug]);
            }

            $key[str_replace(base_path(), '', $file)] = $filters;
        }

        if ($debug = array_search('debug', $filters)) {
            unset($filters[$debug]);
        }

        $theme = $this->themes->active();

        return md5(var_export([$key, $filters, $theme], true));
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
     * Set the publish flag.
     *
     * @param  $publish
     * @return $this
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;

        return $this;
    }

    /**
     * Return nothing.
     *
     * @return string
     */
    function __toString()
    {
        return '';
    }
}
