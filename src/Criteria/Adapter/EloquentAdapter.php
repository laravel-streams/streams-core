<?php

namespace Streams\Core\Criteria\Adapter;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Streams\Core\Entry\Contract\EntryInterface;

class EloquentAdapter extends AbstractAdapter
{

    /**
     * The database query.
     *
     * @var Builder
     */
    protected $query;

    /**
     * The entry stream.
     *
     * @var Stream
     */
    protected $stream;

    /**
     * Create a new class instance.
     *
     * @param Stream $stream
     */
    public function __construct(Stream $stream)
    {
        $this->stream = $stream;

        $model = $stream->config('source.model');

        $stream->config('abstract', $model);

        $this->query = (new $model)->newQuery();
    }

    /**
     * Order the query by field/direction.
     *
     * @param string $field
     * @param string|null $direction
     * @param string|null $value
     */
    public function orderBy($field, $direction = 'asc')
    {
        $this->query = $this->query->orderBy($field, $direction);

        return $this;
    }

    /**
     * Limit the entries returned.
     *
     * @param int $limit
     * @param int|null $offset
     */
    public function limit($limit, $offset = 0)
    {
        $this->query = $this->query->take($limit)->skip($offset);

        return $this;
    }

    /**
     * Constrain the query by a typical 
     * field, operator, value argument.
     *
     * @param string $field
     * @param string|null $operator
     * @param string|null $value
     * @param string|null $nested
     * @return $this
     */
    public function where($field, $operator = null, $value = null, $nested = null)
    {
        if (!$value) {
            $value = $operator;
            $operator = '=';
        }

        $method = Str::studly($nested ? $nested . '_where' : 'where');

        $this->query = $this->query->{$method}($field, $operator, $value);

        return $this;
    }

    /**
     * Include soft deleted records in the results.
     */
    public function withTrashed($toggle)
    {
        if ($toggle) {
            $this->query = $this->query->withTrashed();
        }
    }

    /**
     * Set the relationships that should be eager loaded.
     *
     * @param  string|array  $relations
     */
    public function with($relations)
    {
        $this->query = $this->query->with($relations);
    }

    /**
     * Get the criteria results.
     * 
     * @param array $parameters
     * @return Collection
     */
    public function get(array $parameters = []): Collection
    {
        $this->callParameterMethods($parameters);

        return $this->collect($this->query->get());
    }

    /**
     * Count the criteria results.
     * 
     * @param array $parameters
     * @return int
     */
    public function count(array $parameters = [])
    {
        $this->callParameterMethods($parameters);

        return $this->query->count();
    }

    /**
     * Save an entry.
     *
     * @param  Model $entry
     * @return bool
     */
    public function save($entry)
    {
        return $entry->save();
    }

    /**
     * Delete results.
     *
     * @param array $parameters
     * @return bool
     */
    public function delete(array $parameters = [])
    {
        $this->callParameterMethods($parameters);
        
        return $this->query->delete();
    }

    /**
     * Truncate all entries.
     *
     * @return void
     */
    public function truncate()
    {
        $this->query->truncate();
    }

    /**
     * Return an entry interface from a file.
     *
     * @param $entry
     * @return EntryInterface
     */
    protected function make($entry)
    {
        return $entry;
    }

    public function newInstance(array $attributes = []): EntryInterface
    {
        $model = $this->stream->config('source.model');

        $model = new $model($attributes);

        return $model;
    }
}
