<?php

namespace Streams\Core\Criteria\Adapter;

use Filebase\Database;
use Illuminate\Support\Arr;
use Streams\Core\Entry\Entry;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\HasMemory;
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
     * Constrain the query by a typical 
     * field, operator, value argument.
     *
     * @param string $field
     * @param string|null $operator
     * @param string|null $value
     * @param string|null $nested
     */
    public function orWhere($field, $operator = null, $value = null)
    {
        return $this->where($field, $operator, $value, 'or');
    }

    /**
     * Get the criteria results.
     * 
     * @param array $parameters
     * @return Collection
     */
    abstract public function get(array $parameters = []): Collection;

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
    public function create(array $attributes = [])
    {
        $entry = $this->newInstance($attributes);

        $this->save($entry);

        return $entry;
    }

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
     * @param array $parameters
     * @return bool
     */
    abstract public function delete(array $parameters = []);

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
        $collection = $this->stream->repository()->newCollection();

        if ($entries instanceof Collection) {
            $entries = $entries->all();
        }

        array_map(function ($entry) use ($collection) {
            $entry = $this->make($entry);
            // @todo this is where all entries get stream info.
            // Maybe we do like __stream to prevent collision 
            $entry->stream = $this->stream;
            $collection->push($entry);
        }, $entries);

        return $collection;
    }

    /**
     * Return an entry interface from a file.
     *
     * @param $entry
     * @return EntryInterface
     */
    protected function make($entry)
    {
        $data = Arr::undot($entry->toArray());

        return $this->newInstance(array_merge(
            [
                'id' => $entry->getId(),
                'created_at' => date('Y-m-d H:i:s', Arr::get($data, '__created_at', Arr::get($data, 'created_at'))),
                'updated_at' => date('Y-m-d H:i:s', Arr::get($data, '__updated_at', Arr::get($data, 'updated_at'))),
            ],
            $data
        ));
    }

    public function newInstance(array $attributes = [])
    {
        $prototype = $this->stream->config('abstract', Entry::class);

        $attributes['stream'] = $this->stream;

        $prototype = new $prototype([
            'stream' => $this->stream,
        ]);

        $prototype->loadPrototypeProperties($this->stream->fields->toArray());

        foreach ($this->stream->fields as $field) {

            if (!$default = $field->config('default')) {
                continue;
            }

            if (array_key_exists($field->handle, $attributes)) {
                continue;
            }

            $attributes[$field->handle] = $field->type()->default($default);
        }

        $prototype->loadPrototypeAttributes($attributes);

        return $prototype;
    }
}
