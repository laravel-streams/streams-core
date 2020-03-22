<?php

namespace Anomaly\Streams\Platform\Image\Concerns;

/**
 * Trait HasVersion
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasVersion
{

    /**
     * The version flag.
     *
     * @var null|boolean
     */
    protected $version;
    
    /**
     * Set the version flag.
     *
     * @param bool $version
     * @return $this
     */
    public function version($version = true)
    {
        return $this->setVersion($version);
    }
    
    /**
     * Get the file name.
     *
     * @return null|string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set the file name.
     *
     * @param $version
     * @return $this
     */
    public function setVersion($version = true)
    {
        $this->version = $version;

        return $this;
    }
    

}
