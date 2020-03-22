<?php

namespace Anomaly\Streams\Platform\Image\Concerns;

/**
 * Trait HasExtension
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasExtension
{

    /**
     * The file extension.
     *
     * @var null|string
     */
    protected $extension;

    /**
     * Get the extension.
     *
     * @return null|string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set the extension.
     *
     * @param $extension
     * @return $this
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }
    
    /**
     * Return the image extension.
     *
     * @return string
     */
    public function extension()
    {
        if ($this->extension) {
            return $this->extension;
        }

        return $this->extension = pathinfo($this->source, PATHINFO_EXTENSION);
    }

}
