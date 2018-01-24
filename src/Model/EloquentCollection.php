<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Support\Decorator;
use Anomaly\Streams\Platform\Traits\Hookable;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class EloquentCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EloquentCollection extends Collection
{

    use Hookable;

    /**
     * Return the item IDs.
     *
     * @return array
     */
    public function ids()
    {
        return $this->pluck('id')->all();
    }

    /**
     * Return decorated items.
     *
     * @return static|$this
     */
    public function decorated()
    {
        return $this->decorate();
    }

    /**
     * Return undecorated items.
     *
     * @return static|$this
     */
    public function undecorated()
    {
        return $this->undecorate();
    }

    /**
     * Pad to the specified size with a value.
     *
     * @param        $size
     * @param  null $value
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
        return $this->undecorated()->first(
            function ($entry) use ($key, $value) {
                return $entry->{$key} === $value;
            }
        );
    }

    /**
     * Find a model by key.
     *
     * @param $key
     * @param $value
     * @return static|$this
     */
    public function filterBy($key, $value)
    {
        /* @var Decorator $decorator */
        $decorator = app(Decorator::class);

        return $this->filter(
            function ($entry) use ($key, $value, $decorator) {
                return $decorator->undecorate($entry)->{$key} === $value;
            }
        );
    }

    /**
     * Group an associative array by a field or using a callback.
     *
     * @param  callable|string $groupBy
     * @param  bool $preserveKeys
     * @return static
     */
    public function groupBy($groupBy, $preserveKeys = false)
    {
        $groupBy = $this->valueRetriever($groupBy);
        $results = [];

        foreach ($this->items as $key => $value) {
            $groupKeys = $groupBy($value, $key);

            if (!is_array($groupKeys)) {
                $groupKeys = [$groupKeys];
            }

            foreach ($groupKeys as $groupKey) {
                $groupKey = is_bool($groupKey) || is_int($groupKey)
                    ? (int)$groupKey
                    : (string)$groupKey;

                if (!array_key_exists($groupKey, $results)) {
                    $results[$groupKey] = new static;
                }

                $results[$groupKey]->offsetSet($preserveKeys ? $key : null, $value);
            }
        }

        return new static($results);
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

    /**
     * Return decorated items.
     *
     * @return static|$this
     */
    public function decorate()
    {
        return new static((new Decorator())->decorate($this->items));
    }

    /**
     * Return undecorated items.
     *
     * @return static|$this
     */
    public function undecorate()
    {
        return new static((new Decorator())->undecorate($this->items));
    }

    /**
     * Map to get.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if ($this->hasHook($name)) {
            return $this->call($name, []);
        }

        if ($this->has($name)) {
            return $this->get($name);
        }

        return call_user_func([$this, camel_case($name)]);
    }

    /**
     * Map to get.
     *
     * @param string $method
     * @param array $parameters
     */
    public function __call($method, $parameters)
    {
        if (self::hasMacro($method)) {
            return parent::__call($method, $parameters);
        }

        if ($this->hasHook($hook = snake_case($method))) {
            return $this->call($hook, $parameters);
        }

        return $this->get($method);
    }
}
