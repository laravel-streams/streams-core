<?php namespace Anomaly\Streams\Platform\Model;

use Illuminate\Database\Eloquent\Collection;

class EloquentCollection extends Collection
{

    /**
     * Return the item IDs.
     *
     * @return array
     */
    public function ids()
    {
        return $this->lists('id')->all();
    }

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
     * Pad to the specified size with a value.
     *
     * @param        $size
     * @param  null  $value
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
     * Find a model by key.
     *
     * @param $key
     * @param $value
     * @return EloquentModel
     */
    public function findBy($key, $value)
    {
        return $this->first(
            function ($index, $entry) use ($key, $value) {
                return $entry->{$key} === $value;
            }
        );
    }

    /**
     * An alias for slice.
     *
     * @param $offset
     * @return $this
     */
    public function skip($offset)
    {
        return $this->slice($offset, null, true);
    }
}
