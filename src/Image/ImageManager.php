<?php

namespace Anomaly\Streams\Platform\Image;

use Mobile_Detect;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Intervention\Image\ImageManager as Intervention;

/**
 * Class ImageManager
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ImageManager
{

    /**
     * Image path hints by namespace.
     *
     * @var ImagePaths
     */
    protected $paths;

    /**
     * Create a new Image instance.
     *
     * @param ImagePaths $paths
     */
    public function __construct(ImagePaths $paths)
    {
        $this->paths = $paths;
    }

    /**
     * Make a new image instance.
     *
     * @param  mixed $source
     * @return $this
     */
    public function make($source)
    {
        return new Image($source);
    }

    /**
     * Resolve a hinted path.
     *
     * @param string $path
     */
    public function resolve($path)
    {
        return $this->paths->resolve($path);
    }

    /**
     * Add a path by it's namespace hint.
     *
     * @param $namespace
     * @param $path
     * @return $this
     */
    public function addPath($namespace, $path)
    {
        $this->paths->addPath($namespace, $path);

        return $this;
    }

    /**
     * Return the output.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->output();
    }
}
