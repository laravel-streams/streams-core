<?php namespace Streams\Core\Asset;

use Assetic\Asset\GlobAsset;
use Assetic\Asset\FileAsset;
use Assetic\Asset\AssetCollection;
use Streams\Core\Asset\Filter\JSMinFilter;
use Streams\Core\Asset\Filter\CssMinFilter;
use Streams\Core\Asset\Filter\LessphpFilter;
use Streams\Core\Asset\Filter\ScssphpFilter;
use Streams\Core\Asset\Filter\PhpCssEmbedFilter;

class Asset
{
    /**
     * Asset paths by binding.
     *
     * @var array
     */
    protected $namespaces = [];

    /**
     * Collections of assets by [collection][asset] = filters.
     *
     * @var array
     */
    protected $collections = [];

    /**
     * Add an asset to a collection.
     *
     * @param      $collection
     * @param      $asset
     * @param null $filters
     */
    public function add($collection, $asset, $filters = [])
    {
        if (is_array($asset) and $assets = $asset) {
            foreach ($assets as $asset => $filters) {
                $this->add($asset, $collection, $filters);
            }
        }

        if (!isset($this->collections[$collection])) {
            $this->collections[$collection] = [];
        }

        $this->collections[$collection][$asset] = $filters;
    }

    /**
     * Publish an asset or collection.
     *
     * @param      $identifier
     * @param null $path
     */
    protected function publish($identifier, $path)
    {
        $directory = dirname(public_path($path));

        if (!\File::isDirectory($directory)) {
            \File::makeDirectory($directory, 777, true);
        }

        $data = $this->get($identifier);

        \File::put($path, $data);
    }

    /**
     * Return a filename per the identifier.
     *
     * @param $identifier
     * @return string
     */
    protected function filename($identifier)
    {
        if (isset($this->collections[$identifier])) {
            $filename = \CacheHelper::key($this->collections[$identifier]);
        } else {
            $filename = \CacheHelper::key($identifier);
        }

        return $filename . '.' . \File::extension($identifier);
    }

    /**
     * Get the contents of an identifier.
     *
     * @param $identifier
     * @return mixed
     */
    protected function get($identifier)
    {
        if (isset($this->collections[$identifier]) and $collection = new AssetCollection()) {
            foreach ($this->collections[$identifier] as $asset => $filters) {
                if (strpos($asset, '*') !== false) {
                    $collection->add(new GlobAsset($this->locate($asset), $this->filters($asset, $filters)));
                } else {
                    $collection->add(new FileAsset($this->locate($asset), $this->filters($asset, $filters)));
                }
            }

            return $collection->dump();
        } else {
            return \File::get($this->locate($identifier));
        }
    }

    /**
     * Locate the path of an asset.
     *
     * @param $asset
     */
    protected function locate($asset)
    {
        if (strpos($asset, '::') !== false) {
            list($namespace, $path) = explode('::', $asset);
        } else {
            $namespace = 'theme';
            $path      = \File::extension($asset) . '/' . $asset;
        }

        return $this->namespaces[$namespace] . '/' . $path;
    }

    /**
     * Return an array of filters based on the asset and flags.
     *
     * @param       $asset
     * @param array $filters
     * @return mixed
     */
    protected function filters($asset, $filters = [])
    {
        switch ($extension = \File::extension($asset)) {
            case 'less':
                $filters[] = new LessphpFilter();
                break;
            case 'scss':
                $filters[] = new ScssphpFilter();
                break;
        }

        foreach ($filters as $k => &$filter) {
            if (is_string($filter)) {
                switch ($filter) {
                    case 'min':
                        if (in_array($extension, ['css', 'less', 'scss'])) {
                            $filter = new CssMinFilter();
                        } else {
                            $filter = new JSMinFilter();
                        }
                        break;

                    case 'embed':
                        $filter = new PhpCssEmbedFilter();
                        break;

                    default:
                        unset($filters[$k]);
                        break;
                }
            }
        }

        return $filters;
    }

    /**
     * Pipe the input and return it's public path.
     *
     * @param $identifier
     * @return string
     */
    protected function pipe($identifier)
    {
        $filename = $this->filename($identifier);

        $extension = \File::extension($filename);

        $path = 'assets/' . \Application::getAppRef() . '/' . $extension . '/' . $filename;

        if (!\File::exists($path) or isset($_GET['_compile'])) {
            $this->publish($identifier, $path);
        }

        return $path;
    }

    /**
     * Return the public path by identifier.
     *
     * @param $identifier
     */
    public function path($identifier)
    {
        return $this->pipe($identifier);
    }

    /**
     * Get the URL of a collection file.
     *
     * @param      $identifier
     * @param null $extra
     * @param null $secure
     * @return string
     */
    public function url($identifier, $extra = [], $secure = null)
    {
        $path = $this->pipe($identifier);

        return \URL::to($path, $extra, $secure or \Request::isSecure());
    }

    /**
     * Return a script tag to a collection.
     *
     * @param      $collection
     * @param null $attributes
     * @param null $secure
     * @return string
     */
    public function script($collection, $attributes = [], $secure = null)
    {
        $path = $this->pipe($collection);

        return \HTML::script($path, $attributes, $secure or \Request::isSecure());
    }

    /**
     * Return a style tag to a collection.
     *
     * @param      $collection
     * @param null $attributes
     * @param null $secure
     * @return string
     */
    public function style($collection, $attributes = [], $secure = null)
    {
        $path = $this->pipe($collection);

        return \HTML::style($path, $attributes, $secure or \Request::isSecure());
    }

    /**
     * Render an image tag.
     *
     * @param       $asset
     * @param null  $alt
     * @param array $attributes
     * @param null  $secure
     * @return string
     */
    public function image($asset, $alt = null, $attributes = [], $secure = null)
    {
        $path = $this->pipe($asset);

        return \HTML::image($path, $alt, $attributes, $secure or \Request::isSecure());
    }

    /**
     * Set the namespaces property.
     *
     * @param $namespaces
     * @return $this
     */
    public function setNamespaces($namespaces)
    {
        foreach ($namespaces as $binding => $path) {
            $this->addNamespace($binding, $path);
        }

        return $this;
    }

    /**
     * Add a single namespace path by it's binding.
     *
     * @param $binding
     * @param $path
     */
    public function addNamespace($binding, $path)
    {
        $this->namespaces[$binding] = $path;

        return $this;
    }
}
