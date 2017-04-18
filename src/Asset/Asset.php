<?php namespace Anomaly\Streams\Platform\Asset;

use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Asset\Filter\CoffeeFilter;
use Anomaly\Streams\Platform\Asset\Filter\CssMinFilter;
use Anomaly\Streams\Platform\Asset\Filter\JsMinFilter;
use Anomaly\Streams\Platform\Asset\Filter\LessFilter;
use Anomaly\Streams\Platform\Asset\Filter\NodeLessFilter;
use Anomaly\Streams\Platform\Asset\Filter\ParseFilter;
use Anomaly\Streams\Platform\Asset\Filter\RubySassFilter;
use Anomaly\Streams\Platform\Asset\Filter\RubyScssFilter;
use Anomaly\Streams\Platform\Asset\Filter\SassFilter;
use Anomaly\Streams\Platform\Asset\Filter\ScssFilter;
use Anomaly\Streams\Platform\Asset\Filter\SeparatorFilter;
use Anomaly\Streams\Platform\Asset\Filter\StylusFilter;
use Anomaly\Streams\Platform\Routing\UrlGenerator;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;
use Assetic\Filter\PhpCssEmbedFilter;
use Collective\Html\HtmlBuilder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use League\Flysystem\MountManager;

/**
 * Class Asset
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
     * Groups of assets. Groups can
     * be single files as well.
     *
     * @var array
     */
    protected $collections = [];

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
     * The HTTP request.
     *
     * @var Request
     */
    protected $request;

    /**
     * The stream application.
     *
     * @var Application
     */
    protected $application;

    /**
     * The config repository.
     *
     * @var array
     */
    protected $config;

    /**
     * Create a new Application instance.
     *
     * @param Application     $application
     * @param ThemeCollection $themes
     * @param MountManager    $manager
     * @param AssetParser     $parser
     * @param Repository      $config
     * @param Filesystem      $files
     * @param AssetPaths      $paths
     * @param Request         $request
     * @param HtmlBuilder     $html
     * @param UrlGenerator    $url
     */
    public function __construct(
        Application $application,
        ThemeCollection $themes,
        MountManager $manager,
        AssetParser $parser,
        Repository $config,
        Filesystem $files,
        AssetPaths $paths,
        Request $request,
        HtmlBuilder $html,
        UrlGenerator $url
    ) {
        $this->url         = $url;
        $this->html        = $html;
        $this->files       = $files;
        $this->paths       = $paths;
        $this->config      = $config;
        $this->themes      = $themes;
        $this->parser      = $parser;
        $this->manager     = $manager;
        $this->request     = $request;
        $this->application = $application;
    }

    /**
     * Add an asset or glob pattern to an asset collection.
     *
     * This should support the asset being the collection
     * and the asset (for single files) internally
     * so asset.links / asset.scripts will work.
     *
     * @param             $collection
     * @param             $file
     * @param  array      $filters
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

        /*
         * If this is a remote or single existing
         * file then add it normally.
         */
        if (starts_with($file, ['http', '//']) || file_exists($file)) {
            $this->collections[$collection][$file] = $filters;

            return $this;
        }

        /*
         * If this is a valid glob pattern then add
         * it to the collection and add the glob filter.
         */
        if (count(glob($file)) > 0) {
            $this->collections[$collection][$file] = array_merge($filters, ['glob']);

            return $this;
        }

        if ($this->config->get('app.debug')) {
            throw new \Exception("Asset [{$file}] does not exist!");
        }
    }

    /**
     * Download a file and return it's path.
     *
     * @param              $url
     * @param  int         $ttl
     * @param  null        $path
     * @return null|string
     */
    public function download($url, $ttl = 3600, $path = null)
    {
        $path = $this->paths->downloadPath($url, $path);

        if (!$this->files->isDirectory($directory = dirname($path = public_path(ltrim($path, '/\\'))))) {
            $this->files->makeDirectory($directory, 0777, true);
        }

        if (!$this->files->exists($path) || filemtime($path) < (time() - $ttl)) {
            $this->files->put($path, file_get_contents($url));
        }

        return $path;
    }

    /**
     * Return the contents of a collection.
     *
     * @param         $collection
     * @param  array  $filters
     * @return string
     */
    public function inline($collection, array $filters = [])
    {
        return file_get_contents(
            $this->paths->realPath('public::' . ltrim($this->path($collection, $filters), '/\\'))
        );
    }

    /**
     * Return the URL to a compiled asset collection.
     *
     * @param         $collection
     * @param  array  $filters
     * @return string
     */
    public function url($collection, array $filters = [], array $parameters = [], $secure = null)
    {
        if (!isset($this->collections[$collection])) {
            $this->add($collection, $collection, $filters);
        }

        if (!$path = $this->getPath($collection, $filters)) {
            return null;
        }

        return $this->url->asset($this->getPath($collection, $filters), $parameters, $secure);
    }

    /**
     * Return the path to a compiled asset collection.
     *
     * @param         $collection
     * @param  array  $filters
     * @return string
     */
    public function path($collection, array $filters = [])
    {
        if (!isset($this->collections[$collection])) {
            $this->add($collection, $collection, $filters);
        }

        return $this->request->getBasePath() . $this->getPath($collection, $filters);
    }

    /**
     * Return the asset path to a compiled asset collection.
     *
     * @param         $collection
     * @param  array  $filters
     * @return string
     */
    public function asset($collection, array $filters = [])
    {
        if (!isset($this->collections[$collection])) {
            $this->add($collection, $collection, $filters);
        }

        return $this->path($collection, $filters);
    }

    /**
     * Return the script tag for a collection.
     *
     * @param         $collection
     * @param  array  $filters
     * @param  array  $attributes
     * @return string
     */
    public function script($collection, array $filters = [], array $attributes = [])
    {
        $attributes['src'] = $this->path($collection, $filters);

        return '<script' . $this->html->attributes($attributes) . '></script>';
    }

    /**
     * Return the style tag for a collection.
     *
     * @param         $collection
     * @param  array  $filters
     * @param  array  $attributes
     * @return string
     */
    public function style($collection, array $filters = [], array $attributes = [])
    {
        $defaults = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];

        $attributes = $attributes + $defaults;

        $attributes['href'] = $this->asset($collection, $filters);

        return '<link' . $this->html->attributes($attributes) . '>';
    }

    /**
     * Return an array of script tags.
     *
     * @param        $collection
     * @param  array $filters
     * @param  array $attributes
     * @return array
     */
    public function scripts($collection, array $filters = [], array $attributes = [])
    {
        return array_map(
            function ($path) use ($attributes) {
                $attributes['src'] = $path;

                return '<script' . $this->html->attributes($attributes) . '></script>';
            },
            $this->paths($collection, $filters)
        );
    }

    /**
     * Return an array of style tags.
     *
     * @param        $collection
     * @param  array $filters
     * @param  array $attributes
     * @return array
     */
    public function styles($collection, array $filters = [], array $attributes = [])
    {
        return array_map(
            function ($path) use ($attributes) {
                $defaults = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];

                $attributes = $attributes + $defaults;

                $attributes['href'] = $path;

                return '<link' . $this->html->attributes($attributes) . '>';
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

                    return $this->asset($file, $filters);
                },
                array_keys($this->collections[$collection]),
                array_values($this->collections[$collection])
            )
        );
    }

    /**
     * Return an array of style URLs.
     *
     * @param        $collection
     * @param  array $filters
     * @param  array $attributes
     * @param null   $secure
     * @return array
     */
    public function urls($collection, array $filters = [], array $attributes = [], $secure = null)
    {
        return array_map(
            function ($path) use ($attributes, $secure) {
                return $this->url($path, [], $attributes, $secure);
            },
            $this->paths($collection, $filters)
        );
    }

    /**
     * @param $collection
     * @param $filters
     * @return string
     */
    protected function getPath($collection, $filters)
    {
        /*
         * If the asset is remote just return it.
         */
        if (starts_with($collection, ['http', '//'])) {
            return $collection;
        }

        $path = $this->paths->outputPath($collection);

        if ($this->shouldPublish($path, $collection, $filters)) {
            $this->publish($path, $collection, $filters);
        }

        if (
            !in_array('noversion', $filters) &&
            ($this->config->get('streams::assets.version') || in_array('version', $filters))
        ) {
            $path .= '?v=' . filemtime(public_path(trim($path, '/\\')));
        }

        return $path;
    }

    /**
     * Return the collection path. This
     * is primarily used to determine paths
     * to single assets.
     *
     * @param $collection
     * @return string
     */
    public function getCollectionPath($collection)
    {
        return ($this->request->segment(1) == 'admin' ? 'admin' : 'public') . '/' . ltrim(
                str_replace(base_path(), '', $this->paths->realPath($collection)),
                '/\\'
            );
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
        $path = ltrim($path, '/\\');

        if (str_contains($collection, public_path())) {
            return;
        }

        $assets = $this->getAssetCollection($collection, $additionalFilters);

        $path = $this->directory . DIRECTORY_SEPARATOR . $path;

        $this->files->makeDirectory((new \SplFileInfo($path))->getPath(), 0777, true, true);

        $this->files->put($path, $assets->dump());

        if ($this->paths->extension($path) == 'css') {
            try {
                $this->files->put(
                    $path,
                    app('twig')->render(
                        str_replace($this->application->getAssetsPath(DIRECTORY_SEPARATOR), 'assets::', $path)
                    )
                );
            } catch (\Exception $e) {
                // Don't even..
            }
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

            /*
             * Parse Twg tags in the asset content.
             */
            if ($filter == 'parse') {
                $filter = new ParseFilter($this->parser);

                continue;
            }

            /*
             * Compile LESS to CSS with PHP.
             */
            if ($filter == 'less' && $this->config->get('streams::assets.filters.less', 'php') == 'php') {
                $filter = new LessFilter($this->parser);

                continue;
            }

            /*
             * Compile LESS to CSS with Node.
             */
            if ($filter == 'less' && $this->config->get('streams::assets.filters.less', 'php') == 'node') {
                $filter = new NodeLessFilter($this->parser);

                continue;
            }

            /*
             * Compile Stylus to CSS.
             */
            if ($filter == 'styl') {
                $filter = new StylusFilter($this->parser);

                continue;
            }

            /*
             * Compile SCSS to CSS with PHP.
             */
            if ($filter == 'scss' && $this->config->get('streams::assets.filters.sass', 'php') == 'php') {
                $filter = new ScssFilter($this->parser);

                continue;
            }

            /*
             * Compile SCSS to CSS with Ruby.
             */
            if ($filter == 'scss' && $this->config->get('streams::assets.filters.sass', 'php') == 'ruby') {
                $filter = new RubyScssFilter($this->parser);

                continue;
            }

            /*
             * Compile SASS to CSS with PHP.
             */
            if ($filter == 'sass' && $this->config->get('streams::assets.filters.sass', 'php') == 'php') {
                $filter = new SassFilter($this->parser);

                continue;
            }

            /*
             * Compile SASS to CSS with Ruby.
             */
            if ($filter == 'sass' && $this->config->get('streams::assets.filters.sass', 'php') == 'ruby') {
                $filter = new RubySassFilter($this->parser);

                continue;
            }

            /*
             * Compile CoffeeScript to JS
             */
            if ($filter == 'coffee') {
                $filter = new CoffeeFilter($this->parser);

                continue;
            }

            /*
             * Look for and embed CSS images.
             */
            if ($filter == 'embed') {
                $filter = new PhpCssEmbedFilter();

                continue;
            }

            /*
             * Minify JS
             */
            if ($filter == 'min' && $hint == 'js') {
                $filter = new JsMinFilter();

                continue;
            }

            /*
             * Minify CSS
             */
            if ($filter == 'min' && $hint == 'css') {
                $filter = new CssMinFilter();

                continue;
            }

            /*
             * Glob is a flag that's used later.
             */
            if ($filter == 'glob') {
                continue;
            }

            /*
             * No filter class could be determined!
             */
            $filter = null;
        }

        /*
         * Be sure to separate JS concatenations.
         */
        if ($hint == 'js') {
            $filters[] = new SeparatorFilter();
        }

        return array_filter($filters);
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

        if (ends_with($file, '.styl')) {
            $filters[] = 'styl';
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
        $path = ltrim($path, '/\\');

        if (starts_with($path, 'http')) {
            return false;
        }

        if (!$this->files->exists($path)) {
            return true;
        }

        if (in_array('force', $this->collectionFilters($collection, $filters))) {
            return true;
        }

        $debug = $this->config->get('streams::assets.live', false);

        $live = in_array('live', $this->collectionFilters($collection, $filters));

        if ($debug === true && $live) {
            return true;
        }

        if ($debug == 'public' && $live && $this->request->segment(1) !== 'admin') {
            return true;
        }

        if ($debug == 'admin' && $live && $this->request->segment(1) === 'admin') {
            return true;
        }

        // Merge filters from collection files.
        foreach ($this->collections[$collection] as $fileFilters) {
            $filters = array_filter(array_unique(array_merge($filters, $fileFilters)));
        }

        $assets = $this->getAssetCollection($collection);

        // If any of the files are more recent than the cache file, publish, otherwise skip
        if ($assets->getLastModified() < filemtime($path)) {
            return false;
        }

        return true;
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
     * Create asset collection from collection array
     *
     * @param                  $collection
     * @param  array           $additionalFilters
     * @return AssetCollection
     */
    private function getAssetCollection($collection, $additionalFilters = [])
    {
        $assets = new AssetCollection();

        $hint = $this->paths->hint($collection);

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

        return $assets;
    }

    /**
     * Return the filters used in a collection.
     *
     * @param        $collection
     * @param  array $filters
     * @return array
     */
    protected function collectionFilters($collection, array $filters = [])
    {
        return array_unique(
            array_merge($filters, call_user_func_array('array_merge', array_get($this->collections, $collection, [])))
        );
    }

    /**
     * Return nothing.
     *
     * @return string
     */
    public function __toString()
    {
        return '';
    }
}
