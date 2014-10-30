<?php namespace Anomaly\Streams\Platform\Collection;

use Illuminate\Support\Collection;

class CacheCollection extends Collection
{

    protected $key;

    public function __construct(array $items, $key = null)
    {
        $this->key   = $key;
        $this->items = $items;
    }

    public function addKeys(array $keys = [])
    {
        foreach ($keys as $key) {
            $this->push($key);
        }

        $this->unique();

        return $this;
    }

    public function index()
    {
        if ($keys = app('cache')->get($this->key)) {
            $this->addKeys($keys);
        }

        $this->unique();

        app('cache')->forget($this->key);

        $self = $this;

        app('cache')->rememberForever(
            $this->key,
            function () use ($self) {
                return $self->all();
            }
        );

        return $this;
    }

    public function flush()
    {
        foreach ($this->items as $key) {
            app('cache')->forget($key);
        }

        app('cache')->forget($this->key);

        $this->items = [];

        return $this;
    }

    public function unique()
    {
        $this->items = array_unique($this->items);

        $this->values();

        return $this;
    }

    public function setKey($key = null)
    {
        $this->key = $key;

        return $this;
    }

    public function getKey()
    {
        return $this->key;
    }
}
