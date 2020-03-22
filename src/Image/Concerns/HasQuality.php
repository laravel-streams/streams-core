<?php

namespace Anomaly\Streams\Platform\Image\Concerns;

/**
 * Trait HasQuality
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasQuality
{

    /**
     * The output quality.
     *
     * @var null|int
     */
    protected $quality;
    
    /**
     * Get the quality.
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * Set the quality.
     *
     * @param integer|null $quality
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;

        return $this;
    }

}
