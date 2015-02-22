<?php namespace Anomaly\Streams\Platform\Image;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;

/**
 * Class ImagePlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Image
 */
class ImagePlugin extends Plugin
{

    /**
     * The image utility.
     *
     * @var Image
     */
    protected $image;

    /**
     * Create a new ImagePlugin instance.
     *
     * @param Image $image
     */
    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * Get functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('image_path', [$this->image, 'path']),
            new \Twig_SimpleFunction('image_url', [$this->image, 'url']),
            new \Twig_SimpleFunction('image', [$this->image, 'image'])
        ];
    }
}
