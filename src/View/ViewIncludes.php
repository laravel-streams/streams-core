<?php namespace Anomaly\Streams\Platform\View;

use Illuminate\Support\Collection;

/**
 * Class ViewIncludes
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ViewIncludes extends Collection
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
    public function add($slot, $value)
    {
        if (!$this->has($slot)) {
            $this->put($slot, new Collection());
        }

        $this->put($slot, $value);

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

    /**
     * Override the string output.
     *
     * @return string
     */
    public function __toString()
    {
        return '';
    }
}
