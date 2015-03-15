<?php namespace Anomaly\Streams\Platform\Asset;

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
     * @var array
     */
    protected $paths = [];

    /**
     * Add an asset path hint.
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
