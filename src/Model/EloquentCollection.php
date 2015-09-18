<?php

namespace Anomaly\Streams\Platform\Model;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class EloquentCollection
 * The base eloquent collection used by all our models.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Collection
 */
class EloquentCollection extends Collection
{
    /**
     * Return a collection of decorated items.
     *
     * @return static
     */
    public function decorated()
    {
        $items = [];

        $decorator = app('Robbo\Presenter\Decorator');

        foreach ($this->items as $item) {
            $items[] = $decorator->decorate($item);
        }

        return self::make($items);
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
}
