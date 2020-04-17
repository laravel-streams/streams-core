<?php

namespace Anomaly\Streams\Platform\Image;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Http\Request;

/**
 * Class ImagePaths
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ImagePaths
{

    /**
     * Predefined paths.
     *
     * @var array
     */
    protected $paths = [];

    /**
     * Create a new ImagePaths instance.
     */
    public function __construct()
    {
        $this->paths = config('streams.images.paths', []);
    }

    /**
     * Get the paths.
     *
     * @return array|mixed
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * Set the paths.
     *
     * @param  array $paths
     * @return $this
     */
    public function setPaths(array $paths)
    {
        $this->paths = $paths;

        return $this;
    }

    /**
     * Add an image path hint.
     *
     * @param $namespace
     * @param $path
     * @return $this
     */
    public function addPath($namespace, $path)
    {
        $this->paths[$namespace] = rtrim($path, '/\\');

        return $this;
    }

    /**
     * Return the real path for a given path.
     *
     * @param $path
     * @return string
     * @throws \Exception
     */
    public function resolve($path)
    {
        if (str_contains($path, '::')) {

            list($namespace, $path) = explode('::', $path);

            if (!isset($this->paths[$namespace])) {
                throw new \Exception("Path hint [{$namespace}] does not exist!");
            }

            return rtrim($this->paths[$namespace], '/') . '/' . $path;
        }

        return $path;
    }
}
