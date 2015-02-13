<?php namespace Anomaly\Streams\Platform\Collection;

use Illuminate\Support\Collection;

/**
 * Class CacheCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Collection
 */
class CacheCollection extends Collection
{

    /**
     * The collection key.
     *
     * @var null
     */
    protected $key = null;

    /**
     * Create a new CacheCollection instance.
     *
     * @param array $items
     * @param null  $key
     */
    public function __construct(array $items = [], $key = null)
    {
        $this->key   = $key;
        $this->items = $items;
    }

    /**
     * Add cached keys.
     *
     * @param array $keys
     * @return $this
     */
    public function addKeys(array $keys = [])
    {
        foreach ($keys as $key) {
            $this->push($key);
        }

        $this->unique();

        return $this;
    }

    /**
     * Index the collection.
     *
     * @return $this
     */
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

    /**
     * Flush the cache collection.
     *
     * @return $this
     */
    public function flush()
    {
        $this->index();

        foreach ($this->items as $key) {
            app('cache')->forget($key);
        }

        foreach ($this->items as $key) {
            app('cache')->forget($key);
        }

        app('cache')->forget($this->key);

        $this->items = [];

        return $this;
    }

    /**
     * Make the items unique.
     *
     * @return $this
     */
    public function unique()
    {
        $this->items = array_unique($this->items);

        $this->values();

        return $this;
    }

    /**
     * Set the collection key.
     *
     * @param null $key
     * @return $this
     */
    public function setKey($key = null)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the collection key.
     *
     * @return null
     */
    public function getKey()
    {
        return $this->key;
    }
}
