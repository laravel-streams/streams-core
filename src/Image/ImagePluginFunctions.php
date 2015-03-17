<?php namespace Anomaly\Streams\Platform\Image;

/**
 * Class ImagePluginFunctions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Image
 */
class ImagePluginFunctions
{

    /**
     * The image utility.
     *
     * @var Image
     */
    protected $image;

    /**
     * Create a new ImagePluginFunctions instance.
     *
     * @param Image $image
     */
    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * Return the image instance with URL output.
     *
     * @param $image
     * @return $this
     */
    public function url($image)
    {
        return $this->image->make($image)->setOutput('url');
    }

    /**
     * Return the image instance with path output.
     *
     * @param $image
     * @return $this
     */
    public function path($image)
    {
        return $this->image->make($image)->setOutput('path');
    }

    /**
     * Return the image instance.
     *
     * @param $image
     * @return $this
     */
    public function image($image)
    {
        return $this->image->make($image)->setOutput('image');
    }
}
