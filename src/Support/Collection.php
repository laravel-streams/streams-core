<?php namespace Anomaly\Streams\Platform\Support;

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
     * Return only the provided keys.
     *
     * @param array $keys
     * @return array
     */
    public function only(array $keys)
    {
        return array_intersect_key($this->items, $keys);
    }
}
