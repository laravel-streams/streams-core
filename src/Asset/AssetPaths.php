<?php namespace Anomaly\Streams\Platform\Asset;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;

/**
 * Class AssetPaths
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Asset
 */
class AssetPaths
{

    /**
     * Predefined paths.
     *
     * @var array
     */
    protected $paths = [];

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The application object.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new AssetPaths instance.
     *
     * @param Repository $config
     * @param Request    $request
     */
    public function __construct(Repository $config, Request $request, Application $application)
    {
        $this->config      = $config;
        $this->request     = $request;
        $this->application = $application;

        $this->paths = $config->get('streams::assets.paths', []);
    }

    /**
     * Add an asset path hint.
     *
     * @param $namespace
     * @param $path
     * @return $this
     */
    public function addPath($namespace, $path)
    {
        $this->paths[$namespace] = $path;

        return $this;
    }

    /**
     * Return the hinted extension.
     *
     * @param $path
     * @return string
     */
    public function hint($path)
    {
        $hint = $hint = $this->extension($path);

        foreach ($this->config->get('streams::assets.hints', []) as $extension => $hints) {
            if (in_array($hint, $hints)) {
                return $extension;
            }
        }

        return $hint;
    }

    /**
     * Return the extension of the path.
     *
     * @param $path
     * @return string
     */
    public function extension($path)
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    /**
     * Return the real path for a given path.
     *
     * @param $path
     * @return string
     * @throws \Exception
     */
    public function realPath($path)
    {
        if (str_contains($path, '::')) {

            list($namespace, $path) = explode('::', $path);

            if (!isset($this->paths[$namespace])) {
                throw new \Exception("Path hint [{$namespace}::{$path}] does not exist!");
            }

            return rtrim($this->paths[$namespace], '/') . '/' . $path;
        }

        return $path;
    }

    /**
     * Return the output path.
     *
     * @param $collection
     * @return string
     */
    public function outputPath($collection)
    {

        /**
         * If the path is already public
         * then just use it as it is.
         */
        if (str_contains($collection, public_path())) {
            return str_replace(public_path(), '', $collection);
        }

        /**
         * Get the real path relative to our installation.
         */
        $path = str_replace(base_path(), '', $this->realPath($collection));

        /**
         * Build out path parts.
         */
        $application = $this->application->getReference() . '/';
        $directory   = trim(ltrim(dirname($path), '/') . '/', '\.\/');
        $prefix      = $this->request->segment(1) != 'admin' ?: 'admin/';
        $filename    = basename($path, $this->extension($path)) . $this->hint($path);

        return "/assets/{$application}{$prefix}{$directory}{$filename}";
    }
}
