<?php

namespace Anomaly\Streams\Platform\Image;

/**
 * Class ImageRegistry
 *
 * @link       http://pyrocms.com/
 * @author     PyroCMS, Inc. <support@pyrocms.com>
 * @author     Ryan Thompson <ryan@pyrocms.com>
 */
class ImageRegistry
{

    /**
     * Predefined paths.
     *
     * @var array
     */
    protected $images = [];

    /**
     * Register an image.
     *
     * @param string $name
     * @param string $image
     */
    public function register($name, $image)
    {

        $this->images[$name] = $image;
    }

    /**
     * Resolve an image.
     *
     * @param string $name
     * @param string|null $default
     * @return array
     */
    public function resolve($name, $default = null)
    {
        return array_get($this->images, $name, $default);
    }
}
