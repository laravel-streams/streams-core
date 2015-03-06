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
     * The plugin functions.
     *
     * @var ImagePluginFunctions
     */
    protected $functions;

    /**
     * Create a new ImagePlugin instance.
     *
     * @param ImagePluginFunctions $functions
     */
    public function __construct(ImagePluginFunctions $functions)
    {
        $this->functions = $functions;
    }

    /**
     * Get functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('image_path', [$this->functions, 'path'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('image_url', [$this->functions, 'url'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('image_tag', [$this->functions, 'tag'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('image', [$this->functions, 'image'], ['is_safe' => ['html']])
        ];
    }
}
