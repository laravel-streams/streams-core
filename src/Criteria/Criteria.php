<?php

namespace Streams\Core\Criteria;

use Illuminate\Support\Arr;
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
     * Alias for get.
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
        if (!isset($this->parameters['limit'])) {
            $this->limit(1);
        }

        return $this->get()->first();
    }

    /**
     * Cache the results.
     *
     * @param integer $seconds
     * @param null|string $key
     * @return $this
     */
    public function cache($seconds, $key = null)
    {
        $this->parameters['cache'] = [$seconds, $key];

        return $this;
    }

    /**
     * Order the query by field/direction.
     *
     * @param string $field
     * @param string|null $direction
     * @param string|null $value
     * @return $this
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
     * @return $this
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
     * @return $this
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
        $cache = Arr::get($this->parameters, 'cache', false);

        $fingerprint = $this->stream->handle . '.query__' . md5(serialize($this->parameters));

        if ($cache) {
            return $this->stream->cache(Arr::get($cache, 1) ?: $fingerprint, $cache[0], function () {
                return $this->adapter->get(array_diff_key($this->parameters, array_flip(['cache'])));
            });
        }

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
        $cache = Arr::get($this->parameters, 'cache', false);

        if ($cache) {

            $fingerprint = $this->stream->handle . '.query.count__' . md5(serialize($this->parameters));

            return $this->stream->cache(Arr::get($cache, 1) ?: $fingerprint, $cache[0], function () {
                return $this->adapter->count(array_diff_key($this->parameters, array_flip(['cache'])));
            });
        }

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
        $this->stream->flush();

        return $this->adapter->create($attributes);
    }

    /**
     * Save an entry.
     *
     * @param $entry
     * @return bool
     */
    public function save($entry)
    {
        $this->stream->flush();

        return $this->adapter->save($entry);
    }

    /**
     * Delete an entry.
     *
     * @return bool
     */
    public function delete()
    {
        $this->stream->flush();

        return (bool) $this->adapter->delete($this->parameters);
    }

    /**
     * Truncate all entries.
     *
     * @return void
     */
    public function truncate()
    {
        $this->stream->flush();

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
        return $this->adapter->newInstance($attributes);
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters = [])
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function __call($method, $arguments = [])
    {
        if (static::hasMacro($method)) {
            return $this->callMacroable($method, $arguments);
        }

        if (method_exists($this->adapter, $method)) {
            
            $this->parameters[$method][] = $arguments;

            return $this;
        }

        throw new \BadMethodCallException(sprintf(
            'Method %s::%s does not exist.', static::class, $method
        ));
    }
}
