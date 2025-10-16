<?php

namespace Streams\Core\Image;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class ImagePaths
 *
 * @link   http://pyrocms.com/
 *
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
     * @return string|null
     */
    public function getPath($namespace)
    {
        return Arr::get($this->paths, $namespace);
    }

    /**
     * Return the real path for a given path.
     *
     * @return string
     *
     * @throws \Exception
     */
    public function real($path)
    {
        if (Str::contains($path, '::')) {

            [$namespace, $path] = explode('::', $path);

            if (! isset($this->paths[$namespace])) {
                throw new \Exception("Path hint [{$namespace}] does not exist!");
            }

            $path = rtrim($this->paths[$namespace], '/').'/'.$path;

            if (! filter_var($path, FILTER_VALIDATE_URL)) {
                $path = '/'.$path;
            }
        }

        if (strpos($path, '?v=')) {
            $path = substr($path, 0, strpos($path, '?v='));
        }

        return $path;
    }
}
