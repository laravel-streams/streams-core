<?php

namespace Streams\Core\Criteria\Adapter;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Config;
use Streams\Core\Entry\Contract\EntryInterface;

class DatabaseAdapter extends AbstractAdapter
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

        if (!$connection = $stream->config('source.connection')) {
            $connection = Config::get('database.default');
        }

        $this->query = DB::connection($connection)
            ->table($stream->config('source.table', $stream->id));
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
     * Get the criteria results.
     * 
     * @param array $parameters
     * @return Collection
     */
    public function get(array $parameters = []): Collection
    {
        foreach ($parameters as $key => $call) {

            $method = Str::camel($key);

            foreach ($call as $parameters) {
                call_user_func_array([$this, $method], $parameters);
            }
        }

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
        foreach ($parameters as $key => $call) {

            $method = Str::camel($key);

            foreach ($call as $parameters) {
                call_user_func_array([$this, $method], $parameters);
            }
        }
        
        return $this->query->count();
    }

    /**
     * Create a new entry.
     *
     * @param array $attributes
     * @return EntryInterface
     */
    // public function create(array $attributes = [])
    // {
    //     $id = $this->query->insertGetId($attributes);

    //     return $this->make(['id' => $id] + $attributes);
    // }

    /**
     * Save an entry.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    public function save($entry)
    {
        $attributes = $entry->getAttributes();

        // @todo Configurable key_name
        if ($id = Arr::pull($attributes, 'id')) {
            return $this->query->where('id', $id)->update($attributes);
        }

        $id = $this->query->insertGetId($entry->getAttributes());

        $entry->id = $id;

        return true;
    }

    /**
     * Delete results.
     *
     * @param array $parameters
     * @return bool
     */
    public function delete(array $parameters = [])
    {
        foreach ($parameters as $key => $call) {

            $method = Str::camel($key);

            foreach ($call as $parameters) {
                call_user_func_array([$this, $method], $parameters);
            }
        }

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
        return $this->newInstance((array) $entry);
    }
}
