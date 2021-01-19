<?php

namespace Streams\Core\Criteria;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Entry\Entry;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\HasMemory;
use Illuminate\Pagination\LengthAwarePaginator;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Criteria\Contract\AdapterInterface;

class Criteria
{

    use Macroable;
    use HasMemory;

    /**
     * The criteria parameters.
     *
     * @var array
     */
    protected $parameters = [];

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

    /**
     * Create a new class instance.
     *
     * @param \Streams\Core\Criteria\Contract\AdapterInterface $adapter
     * @param \Streams\Core\Stream\Stream $stream
     * @param array $parameters
     */
    public function __construct(
        AdapterInterface $adapter,
        Stream $stream,
        array $parameters = []
    ) {
        $this->parameters = $parameters;
        $this->adapter = $adapter;
        $this->stream = $stream;
    }

    /**
     * Return all entries.
     * 
     * @return Collection
     */
    public function all()
    {
        return $this->get();
    }

    /**
     * Return the first matching result.
     * 
     * @param string $id
     * @return EntryInterface
     */
    public function find($id)
    {
        return $this->where('id', $id)->get()->first();
    }

    /**
     * Return the first result.
     * 
     * @return null|EntryInterface
     */
    public function first()
    {
        return $this->limit(1)->get()->first();
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
        $this->parameters['order_by'][] = [$field, $direction];

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
        $this->parameters['limit'][] = [$limit, $offset];

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
        $this->parameters['where'][] = [$field, $operator, $value, $nested];

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
    public function orWhere($field, $operator = null, $value = null)
    {
        $this->where($field, $operator, $value, 'or');

        return $this;
    }

    /**
     * Get the criteria results.
     * 
     * @return Collection
     */
    public function get()
    {
        $fingerprint = $this->stream->handle . '__' . md5(serialize($this->parameters));
        
        return $this->once($fingerprint, function () {
            return $this->adapter->get($this->parameters);
        });
    }

    /**
     * Count the criteria results.
     * 
     * @return int
     */
    public function count()
    {
        return $this->adapter->count($this->parameters);
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
    public function paginate($parameters = [])
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
