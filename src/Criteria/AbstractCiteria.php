<?php

namespace Anomaly\Streams\Platform\Criteria;

use Filebase\Database;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Entry\Entry;
use Anomaly\Streams\Platform\Stream\Stream;
use Illuminate\Pagination\LengthAwarePaginator;
use Anomaly\Streams\Platform\Support\Traits\HasMemory;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Criteria\Contract\CriteriaInterface;

/**
 * Class AbstractCiteria
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
abstract class AbstractCiteria implements CriteriaInterface
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
     * Return all entries.
     * 
     * @return Collection
     */
    abstract public function all();

    /**
     * Return all entries.
     * 
     * @param string $id
     * @return EntryInterface
     */
    abstract public function find($id);

    /**
     * Return the first result.
     * 
     * @return null|EntryInterface
     */
    abstract public function first();

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
     * Add a where constraint.
     *
     * @param string $field
     * @param string|null $operator
     * @param string|null $value
     * @return $this
     */
    abstract public function andWhere($field, $operator = null, $value = null);

    /**
     * Add a where constraint.
     *
     * @param string $field
     * @param string|null $operator
     * @param string|null $value
     * @return $this
     */
    abstract public function orWhere($field, $operator = null, $value = null);

    /**
     * Get the criteria results.
     * 
     * @return Collection
     */
    abstract public function get();

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
    public function truncate()
    {
        $this->query->truncate();
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
        $perPage = Arr::get($parameters, 'per_page', 15);
        $pageName = Arr::get($parameters, 'page_name', 'page');
        $limitName = Arr::get($parameters, 'limit_name', 'limit');

        if (!$total) {
            $total = $this->count();
        }

        $page = (int) Request::get($pageName, 1);
        $perPage = (int) Request::get($limitName, $perPage);

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
        $abstract = $this->stream->attr('abstract', Entry::class);

        return new $abstract($this->stream, $attributes);
    }
}
