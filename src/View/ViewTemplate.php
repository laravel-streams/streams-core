<?php

namespace Anomaly\Streams\Platform\View;

use Anomaly\Streams\Platform\Support\Collection;

/**
 * Class ViewTemplate
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ViewTemplate extends Collection
{

    /**
     * The loaded flag.
     *
     * @var bool
     */
    protected $loaded = false;

    /**
     * Set a value.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->put($key, $value);

        return $this;
    }

    /**
     * Get the loaded flag.
     *
     * @return bool
     */
    public function isLoaded()
    {
        return $this->loaded;
    }

    /**
     * Set the loaded flag.
     *
     * @param $loaded
     * @return $this
     */
    public function setLoaded($loaded)
    {
        $this->loaded = $loaded;

        return $this;
    }
}
