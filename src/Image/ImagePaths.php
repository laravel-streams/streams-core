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
     * @var array
     */
    protected $paths = [];

    /**
     * Create a new ImagePaths instance.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->paths = $config->get('streams.image_paths', []);
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
        array_set($this->paths, $namespace, $path);

        return $this;
    }

    /**
     * Return the real path for a given path.
     *
     * @param $path
     * @return string
     */
    public function realPath($path)
    {
        if (str_contains($path, '::')) {

            list($namespace, $path) = explode('::', $path);

            return $this->paths[$namespace] . '/' . $path;
        }

        return $path;
    }
}
