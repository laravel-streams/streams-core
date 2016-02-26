<?php namespace Anomaly\Streams\Platform\Image;

use Illuminate\Config\Repository;

/**
 * Class ImagePaths
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Image
 */
class ImagePaths
{

    /**
     * Registered image paths.
     *
     * @var array
     */
    protected $paths;

    /**
     * Create a new ImagePaths instance.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->paths = $config->get('streams::images.paths', []);
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
     * @param array $paths
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
        $this->paths[$namespace] = $path;

        return $this;
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
}
