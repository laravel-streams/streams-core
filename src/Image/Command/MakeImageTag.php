<?php namespace Anomaly\Streams\Platform\Image\Command;

use Anomaly\Streams\Platform\Image\Image;

/**
 * Class MakeImageTag
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class MakeImageTag
{

    /**
     * The image identifier.
     *
     * @var string
     */
    protected $image;

    /**
     * Create a new MakeImageTag instance.
     *
     * @param $image
     */
    public function __construct($image)
    {
        $this->image = $image;
    }

    /**
     * Handle the command.
     *
     * @param  Image $image
     * @return $this
     */
    public function handle(Image $image)
    {
        return $image->make($this->image)->setOutput('image');
    }
}
