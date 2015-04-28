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
}
