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

    use HasMemory;

    use Macroable {
        Macroable::__call as private callMacroable;
    }

    protected array $parameters = [];

    protected Stream $stream;

    protected AdapterInterface $adapter;

    public function __construct(
        Stream $stream,
        AdapterInterface $adapter,
        array $parameters = []
    ) {
        $this->parameters = $parameters;
        $this->adapter = $adapter;
        $this->stream = $stream;
    }

    /**
     * @param integer|string $id
     * @return null|EntryInterface
     */
    public function find($id)
    {
        return $this->where('id', $id)->get()->first();
    }

    /**
     * @return null|EntryInterface
     */
    public function first()
    {
        if (!isset($this->parameters['limit'])) {
            $this->limit(1);
        }

        return $this->get()->first();
    }

    public function cache(int $seconds = null, string $key = null)
    {
        $seconds = $seconds ?: $this->stream->config('cache.ttl', 60 * 60);

        $this->parameters['cache'] = [$seconds, $key];

        return $this;
    }

    public function fresh()
    {
        unset($this->parameters['cache']);

        return $this;
    }

    public function orderBy(string $field, $direction = 'asc')
    {
        $this->parameters['order_by'][] = [$field, $direction];

        return $this;
    }

    public function limit(int $limit, int $offset = 0)
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
     * @param mixed $value
     * @param string|null $nested
     * @return $this
     */
    public function where(string $field, string $operator = null, $value = null, string $nested = null)
    {
        $this->parameters['where'][] = [$field, $operator, $value, $nested];

        return $this;
    }

    /**
     * @param string $field
     * @param string|null $operator
     * @param mixed $value
     * @return $this
     */
    public function orWhere(string $field, string $operator = null, $value = null)
    {
        $this->where($field, $operator, $value, 'or');

        return $this;
    }

    public function get(): Collection
    {
        $cache = $this->stream->config('cache.enabled', false);
        
        $cache = Arr::get($this->parameters, 'cache', $cache);

        $fingerprint = $this->stream->handle . '.query__' . md5(json_encode($this->parameters));

        if ($cache) {
            return $this->stream->cache()->remember(Arr::get($cache, 1) ?: $fingerprint, $cache[0], function () {
                return $this->adapter->get(array_diff_key($this->parameters, array_flip(['cache'])));
            });
        }

        return $this->adapter->get($this->parameters);

        /**
         * This needs to flush memory (HasMemory) when 
         * $this->streams->flush() is executed.
         */
        // return $this->once($fingerprint, function () {
        //     return $this->adapter->get($this->parameters);
        // });
    }

    public function chunk(int $count, callable $callback): bool
    {
        $page = 1;

        do {
            // We'll execute the query for the given page and get the results. If there are
            // no results we can just break and return from here. When there are results
            // we will call the callback with the current chunk of these results here.
            $results = $this->limit($count, ($page - 1) * $count)->get();

            $countResults = $results->count();

            if ($countResults == 0) {
                break;
            }

            // On each chunk result set, we will pass them to the callback and then let the
            // developer take care of everything within the callback, which allows us to
            // keep the memory low for spinning through large result sets for working.
            if ($callback($results, $page) === false) {
                return false;
            }

            unset($results);

            $page++;
        } while ($countResults == $count);

        return true;
    }

    /**
     * Count the criteria results.
     * 
     * @return int
     */
    public function count()
    {
        $cache = $this->stream->config('cache.enabled', false);
        
        $cache = Arr::get($this->parameters, 'cache', $cache);

        if ($cache) {

            $fingerprint = $this->stream->handle . '.query.count__' . md5(json_encode($this->parameters));

            return $this->stream->cache()->remember(Arr::get($cache, 1) ?: $fingerprint, $cache[0], function () {
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
        $this->stream->cache()->flush();

        return $this->adapter->create($attributes);
    }

    public function save(EntryInterface $entry)
    {
        $this->stream->cache()->flush();

        return $this->adapter->save($entry);
    }

    public function delete(): bool
    {
        $this->stream->cache()->flush();

        return (bool) $this->adapter->delete($this->parameters);
    }

    public function truncate(): void
    {
        $this->stream->cache()->flush();

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

        $page = Arr::get($parameters, 'page');
        $total = Arr::get($parameters, 'total');
        $perPage = Arr::get($parameters, 'per_page');
        $pageName = Arr::get($parameters, 'page_name', 'page');
        $limitName = Arr::get($parameters, 'limit_name', 'limit');

        if (!$total) {
            $total = $this->count();
        }

        if (!$page) {
            $page = (int) Request::get($pageName, 1);
        }

        if (!$perPage) {
            $perPage = (int) Request::get($limitName, $perPage) ?: 25;
        }

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

    public function loadParameters(array $parameters = [])
    {
        foreach ($parameters as $parameter) {
            foreach ($parameter as $method => $arguments) {
                $this->parameters[$method][] = $arguments;
            }
        }

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
            'Method %s::%s does not exist.',
            static::class,
            $method
        ));
    }
}
