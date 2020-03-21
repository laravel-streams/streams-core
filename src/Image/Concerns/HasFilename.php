<?php

namespace Anomaly\Streams\Platform\Image\Concerns;

/**
 * Trait HasFilename
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasFilename
{
    
    /**
     * Set the filename.
     *
     * @param $filename
     * @return $this
     */
    public function rename($filename = null)
    {
        return $this->setFilename($filename);
    }

    /**
     * Get the file name.
     *
     * @return null|string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set the file name.
     *
     * @param $filename
     * @return $this
     */
    public function setFilename($filename = null)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get the original name.
     *
     * @return null|string
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * Set the original name.
     *
     * @param $original
     * @return $this
     */
    public function setOriginal($original = null)
    {
        $this->original = $original;

        return $this;
    }

}
