<?php

namespace Streams\Core\Criteria;

use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Entry\Contract\EntryInterface;

/**
 * Class EloquentCriteria
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class EloquentCriteria extends AbstractCiteria
{

    use Macroable;
    use HasMemory;

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

        $model = $stream->getPrototypeAttribute('source.model');

        $this->query = (new $model)->newQuery();
    }

    /**
     * Return all entries.
     * 
     * @return Collection
     */
    public function all()
    {
        return $this->collect($this->query->get());
    }

    /**
     * Return all entries.
     * 
     * @param string $id
     * @return Collection
     */
    public function find($id)
    {
        return $this->make($this->query->find($id));
    }

    /**
     * Return the first result.
     * 
     * @return null|EntryInterface
     */
    public function first()
    {
        return $this->make($this->query->first());
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

        if ($field == 'handle') {
            $field = $this->stream->getPrototypeAttribute('config.handle', 'id');
        }

        $method = Str::studly($nested ? $nested . '_where' : 'where');

        $this->query = $this->query->{$method}($field, $operator, $value);

        return $this;
    }

    /**
     * Add a where constraint.
     *
     * @param string $field
     * @param string|null $operator
     * @param string|null $value
     * @return $this
     */
    public function andWhere($field, $operator = null, $value = null)
    {
        return $this->where($field, $operator, $value, 'and');
    }

    /**
     * Add a where constraint.
     *
     * @param string $field
     * @param string|null $operator
     * @param string|null $value
     * @return $this
     */
    public function orWhere($field, $operator = null, $value = null)
    {
        return $this->where($field, $operator, $value, 'or');
    }

    /**
     * Get the criteria results.
     * 
     * @return Collection
     */
    public function get()
    {
        return $this->collect($this->query->get());
    }

    /**
     * Count the criteria results.
     * 
     * @return int
     */
    public function count()
    {
        return $this->query->count();
    }

    /**
     * Create a new entry.
     *
     * @param array $attributes
     * @return EntryInterface
     */
    public function create(array $attributes = [])
    {
        return $this->query->create($attributes);
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
     * Delete an entry.
     *
     * @param EntryInterface $entry
     * @return bool
     */
    public function delete(EntryInterface $entry)
    {
        return $this->query
            ->get($entry->id)
            ->delete();
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
     * Return an entry instance.
     *
     * @param array $attributes
     * @return EntryInterface
     */
    public function newInstance(array $attributes = [])
    {
        $model = $this->stream->getPrototypeAttribute('config.model');

        return new $model($this->stream, $attributes);
    }
}
