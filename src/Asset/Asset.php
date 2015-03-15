<?php namespace Anomaly\Streams\Platform\Asset;

use Anomaly\Streams\Platform\Application\Application;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;
use Assetic\Filter\CoffeeScriptFilter;
use Assetic\Filter\CssMinFilter;
use Assetic\Filter\JSMinFilter;
use Assetic\Filter\LessphpFilter;
use Assetic\Filter\PhpCssEmbedFilter;
use Assetic\Filter\ScssphpFilter;

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
     * Asset path hints by namespace.
     *
     * 'module.users' => 'the/resources/path'
     *
     * @var AssetPaths
     */
    protected $paths;

    /**
     * The stream application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new Application instance.
     *
     * @param Application $application
     * @param AssetPaths  $paths
     */
    public function __construct(Application $application, AssetPaths $paths)
    {
        $this->paths       = $paths;
        $this->application = $application;
    }

    /**
     * Add an asset or glob pattern to an asset collection.
     *
     * This should support the asset being the collection
     * and the asset (for single files) internally
     * so asset.links / asset.scripts will work.
     *
     * @param        $collection
     * @param        $asset
     * @param  array $filters
     */
    public function add($collection, $file, array $filters = [])
    {
        if (!isset($this->collections[$collection])) {
            $this->collections[$collection] = [];
        }

        $filters = $this->addConvenientFilters($file, $filters);

        $file = $this->paths->realPath($file);

        if (file_exists($file) || is_dir(trim($file, '*'))) {
            $this->collections[$collection][$file] = $filters;
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

        return 'assets/' . $this->application->getReference() . '/' . $hash . '.' . $hint;
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

            if (ends_with($file, '*')) {
                $file = new GlobAsset($file, $filters);
            } else {
                $file = new FileAsset($file, $filters);
            }

            $assets->add($file);
        }

        $path = $this->directory . $path;

        $files = app('files');

        $files->makeDirectory((new \SplFileInfo($path))->getPath(), 777, true, true);

        $files->put($path, $assets->dump());

        if ($this->getExtension($path) == 'css') {
            $files->put($path, app('twig')->render(str_replace($this->directory, 'assets::', $path)));
        }
    }

    /**
     * Transform an array of filters to
     * an array of assetic filters.
     *
     * @param  $filters
     * @param  $hint
     * @return mixed
     */
    protected function transformFilters($filters, $hint)
    {
        foreach ($filters as $k => &$filter) {
            switch ($filter) {
                case 'less':
                    $filter = new LessphpFilter();
                    break;

                case 'scss':
                    $filter = new ScssphpFilter();
                    break;

                case 'coffee':
                    $filter = new CoffeeScriptFilter();
                    break;

                case 'embed':
                    $filter = new PhpCssEmbedFilter();
                    break;

                case 'min':
                    if ($hint == 'js') {
                        $filter = new JSMinFilter();
                    } elseif ($hint == 'css') {
                        $filter = new CssMinFilter();
                    }
                    break;

                default:
                    unset($filters[$k]);
                    break;
            }
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
            $key[str_replace(base_path(), '', $file)] = $filters;
        }

        return md5(var_export([$key, $filters], true));
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
}
