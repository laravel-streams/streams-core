<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Contracts\Config\Repository;

/**
 * Class Collection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Collection extends \Illuminate\Support\Collection
{

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * Create a new Collection instance.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        $this->config = config();

        parent::__construct($items);
    }

    /**
     * Return shuffled items.
     *
     * @param int $amount
     * @return static
     */
    public function shuffle()
    {
        $shuffled = [];

        $keys = array_keys($this->items);

        shuffle($keys);

        foreach ($keys as $key) {
            $shuffled[$key] = $this->items[$key];
        }

        return new static($shuffled);
    }

    /**
     * Pad to the specified size with a value.
     *
     * @param       $size
     * @param null  $value
     * @return $this
     */
    public function pad($size, $value = null)
    {
        if ($this->isEmpty()) {
            return $this;
        }

        if ($value) {
            return new static(array_pad($this->items, $size, $value));
        }

        while ($this->count() < $size) {
            $this->items = array_merge($this->items, $this->items);
        }

        return new static($this->items);
    }

    /**
     * Get a field with the __get accessor.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Get a field with the __call accessor.
     *
     * @param $name
     * @param $arguments
     */
    function __call($name, $arguments)
    {
        return $this->get($name);
    }
}
