<?php

namespace Streams\Core\Criteria\Adapter;

use Filebase\Database;
use Illuminate\Support\Arr;
use Streams\Core\Entry\Entry;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\HasMemory;
use Illuminate\Pagination\LengthAwarePaginator;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Criteria\Contract\AdapterInterface;

abstract class AbstractAdapter implements AdapterInterface
{

    use Macroable;
    use HasMemory;

    /**
     * The database query.
     *
     * @var Database
     */
    protected $query;

    /**
     * The entry stream.
     *
     * @var Stream
     */
    protected $stream;

    /**
     * Order the query by field/direction.
     *
     * @param string $field
     * @param string|null $direction
     * @param string|null $value
     */
    abstract public function orderBy($field, $direction = 'asc');

    /**
     * Limit the entries returned.
     *
     * @param int $limit
     * @param int|null $offset
     */
    abstract public function limit($limit, $offset = 0);

    /**
     * Constrain the query by a typical 
     * field, operator, value argument.
     *
     * @param string $field
     * @param string|null $operator
     * @param string|null $value
     * @param string|null $nested
     */
    abstract public function where($field, $operator = null, $value = null, $nested = null);

    /**
     * Get the criteria results.
     * 
     * @param array $parameters
     * @return Collection
     */
    abstract public function get(array $parameters = []);

    /**
     * Count the criteria results.
     * 
     * @return int
     */
    abstract public function count();

    /**
     * Create a new entry.
     *
     * @param array $attributes
     * @return EntryInterface
     */
    abstract public function create(array $attributes = []);

    /**
     * Save an entry.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    abstract public function save(EntryInterface $entry);

    /**
     * Delete an entry.
     *
     * @param EntryInterface $entry
     * @return bool
     */
    abstract public function delete(EntryInterface $entry);

    /**
     * Truncate all entries.
     *
     * @return void
     */
    abstract public function truncate();

    /**
     * Return an entry collection.
     *
     * @param array $entries
     * @return Collection
     */
    protected function collect($entries)
    {
        $collection = $this->stream->getPrototypeAttribute('source.collection') ?: Collection::class;

        $collection = new $collection;

        array_map(function ($entry) use ($collection) {
            $entry = $this->make($entry);
            $collection->put($entry->id, $entry);
        }, (array) $entries);

        return $collection;
    }

    /**
     * Return an entry instance.
     *
     * @param array $attributes
     * @return EntryInterface
     */
    public function newInstance(array $attributes = [])
    {
        $prototype = $this->stream->getPrototypeAttribute('config.prototype') ?: Entry::class;// @todo or 'config.abstract' as a general term.

        $attributes['stream'] = $this->stream;

        $prototype = new $prototype($attributes);

        $prototype->loadPrototypeProperties($this->stream->fields->toArray());

        return $prototype;
    }
}
