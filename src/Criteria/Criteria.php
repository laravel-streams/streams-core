<?php

namespace Streams\Core\Criteria;

use Illuminate\Support\Arr;
use Streams\Core\Entry\Entry;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Entry\Contract\EntryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Streams\Core\Criteria\Contract\AdapterInterface;
use Streams\Core\Criteria\Contract\CriteriaInterface;

class Criteria implements CriteriaInterface
{

    use Macroable;
    use HasMemory;

    /**
     * The source adapter.
     *
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * The entry stream.
     *
     * @var Stream
     */
    protected $stream;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Return all entries.
     * 
     * @return Collection
     */
    public function all()
    {
        return $this->adapter->all();
    }

    /**
     * Return all entries.
     * 
     * @param string $id
     * @return EntryInterface
     */
    public function find($id)
    {
        return $this->adapter->find($id);
    }

    /**
     * Return the first result.
     * 
     * @return null|EntryInterface
     */
    public function first()
    {
        return $this->adapter->first();
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
        $this->adapter->orderBy($field, $direction);

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
        $this->adapter->limit($limit, $offset);

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
     */
    public function where($field, $operator = null, $value = null, $nested = null)
    {
        $this->adapter->where($field, $operator, $value, $nested);

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
    //abstract public function andWhere($field, $operator = null, $value = null);

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
        $this->adapter->orWhere($field, $operator, $value);

        return $this;
    }

    /**
     * Get the criteria results.
     * 
     * @return Collection
     */
    public function get()
    {
        return $this->adapter->get();
    }

    /**
     * Count the criteria results.
     * 
     * @return int
     */
    public function count()
    {
        return $this->adapter->count();
    }

    /**
     * Create a new entry.
     *
     * @param array $attributes
     * @return EntryInterface
     */
    public function create(array $attributes = [])
    {
        return $this->adapter->create($attributes);
    }

    /**
     * Save an entry.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    public function save(EntryInterface $entry)
    {
        return $this->adapter->save($entry);
    }

    /**
     * Delete an entry.
     *
     * @param $entry
     * @return bool
     */
    public function delete($entry)
    {
        return $this->adapter->delete($entry);
    }

    /**
     * Truncate all entries.
     *
     * @return void
     */
    public function truncate()
    {
        $this->adapter->truncate();
    }

    /**
     * Return paginated entries.
     *
     * @param  array|int $parameters
     * @return Paginator
     */
    public function paginate($parameters = null)
    {
        if (is_numeric($parameters)) {
            $parameters = [
                'per_page' => $parameters,
            ];
        }

        $path = Request::url();

        $total = Arr::get($parameters, 'total');
        $perPage = Arr::get($parameters, 'per_page', 25);
        $pageName = Arr::get($parameters, 'page_name', 'page');
        $limitName = Arr::get($parameters, 'limit_name', 'limit');

        if (!$total) {
            $total = $this->count();
        }

        $page = (int) Request::get($pageName, 1);
        $perPage = (int) Request::get($limitName, $perPage) ?: 9999;

        $offset = $page * $perPage - $perPage;

        $entries = $this->limit($perPage, $offset)->get();

        $paginator = new LengthAwarePaginator(
            $entries,
            $total,
            $perPage,
            $page,
            [
                'path' => $path,
                'pageName' => $pageName,
            ]
        );

        $paginator->appends(Request::all());

        return $paginator;
    }

    /**
     * Return an entry instance.
     *
     * @param array $attributes
     * @return EntryInterface
     */
    public function newInstance(array $attributes = [])
    {
        $prototype = $this->stream->getPrototypeAttribute('config.prototype') ?: Entry::class; // @todo or 'config.abstract' as a general term.

        $attributes['stream'] = $this->stream;

        $prototype = new $prototype($attributes);

        $prototype->loadPrototypeProperties($this->stream->fields->toArray());

        return $prototype;
    }
}
