<?php

namespace Streams\Core\Asset;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AssetPaths
{

    /**
     * Predefined paths.
     *
     * @var array
     */
    protected $paths = [];

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
     * Add an asset path hint.
     *
     * @param $namespace
     * @param $path
     * @return $this
     */
    public function addPath($namespace, $path)
    {
        $this->paths[$namespace] = rtrim(ltrim($path, '/\\'), '/\\');

        return $this;
    }

    /**
     * Get a single path.
     *
     * @param $namespace
     * @return string|null
     */
    public function getPath($namespace)
    {
        return Arr::get($this->paths, $namespace);
    }

    /**
     * Return the real public
     * path for a given asset.
     *
     * @param $asset
     * @return string
     * @throws \Exception
     */
    public function real($asset)
    {
        if (Str::contains($asset, '::')) {

            list($namespace, $asset) = explode('::', $asset);

            if (!isset($this->paths[$namespace])) {
                throw new \Exception("Path hint [{$namespace}::{$asset}] does not exist!");
            }

            $asset = $this->paths[$namespace] . '/' . $asset;

            if (!filter_var($asset, FILTER_VALIDATE_URL)) {
                $asset = '/' . $asset;
            }
        }

        if (strpos($asset, '?v=')) {
            $asset = substr($asset, 0, strpos($asset, '?v='));
        }

        return $asset;
    }
}
