<?php

namespace Anomaly\Streams\Platform\Image;

use Anomaly\Streams\Platform\Image\ImageRegistry;

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
     * The image registry.
     *
     * @var ImageRegistry
     */
    protected $registry;

    /**
     * Create a new Image instance.
     *
     * @param ImagePaths $paths
     * @param ImageRegistry $registry
     */
    public function __construct(ImagePaths $paths, ImageRegistry $registry)
    {
        $this->paths    = $paths;
        $this->registry = $registry;
    }

    /**
     * Make a new image instance.
     *
     * @param  mixed $source
     * @return Image
     */
    public function make($source)
    {
        return (new Image($source))
            ->setOriginal(basename($source));
    }

    /**
     * Register an image by name.
     *
     * @param string $name
     * @param string $image
     * @return $this
     */
    public function register($name, $image)
    {
        $this->registry->register($name, $image);

        return $this;
    }

    /**
     * Resolve a hinted path.
     *
     * @param string $path
     * @param default|null $default
     * @return string|null
     */
    public function resolve($name, $default = null)
    {
        return $this->registry->resolve($name, $default);
    }

    /**
     * Guess an image's
     * registered path.
     *
     * @param string $image
     */
    public function path($image)
    {
        return $this->paths->resolve(
            $this->registry->resolve($image) ?: $image
        );
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
}
