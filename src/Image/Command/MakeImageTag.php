<?php namespace Anomaly\Streams\Platform\Image\Command;

use Anomaly\Streams\Platform\Image\Image;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class MakeImageTag
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Image\Command
 */
class MakeImageTag implements SelfHandling
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
     * @param Image $image
     * @return $this
     */
    public function handle(Image $image)
    {
        return $image->make($this->image)->setOutput('image');
    }
}
