<?php

namespace Anomaly\Streams\Platform\Criteria;

use Filebase\Database;
use Filebase\Document;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Entry\Entry;
use Anomaly\Streams\Platform\Traits\HasMemory;
use Illuminate\Pagination\LengthAwarePaginator;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Criteria\Contract\CriteriaInterface;

/**
 * Class FilebaseCriteria
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FilebaseCriteria implements CriteriaInterface
{

    use Macroable;
    use HasMemory;

    /**
     * The database query.
     *
     * @var Query
     */
    protected $query;

    /**
     * The entry stream.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new class instance.
     *
     * @param StreamInterface $stream
     */
    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;

        $this->query = new Database([
            // @todo IDE not hinting
            'dir' => base_path($stream->attr('filebase', 'streams/data/' . $stream->slug)),

            //'backupLocation' => 'path/to/database/backup/dir',
            //'format'         => \Filebase\Format\Json::class,
            'cache'          => false,
            //'cache_expires'  => 1800,
            'pretty'         => true,
            'safe_filename'  => true,
            //'read_only'      => false,
            //'rules' => []
        ]);
    }

    /**
     * Return all entries.
     * 
     * @return Collection
     */
    public function all()
    {
        return $this->collect($this->query->findAll());
    }

    /**
     * Return all entries.
     * 
     * @param string $id
     * @return Collection
     */
    public function find($id)
    {
        if (!$this->query->has($id)) {
            return null;
        }

        return $this->make($this->query->get($id));
    }

    /**
     * Return the first result.
     * 
     * @return null|EntryInterface
     */
    public function first()
    {
        if (!$result = $this->query->first()) {
            return null;
        }

        return $this->make($result);
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
        $this->query = $this->query->limit($limit, $offset);

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
        if (!$value) {
            $value = $operator;
            $operator = '=';
        }

        if ($field == 'id') {
            $field = '__id';
        }

        $method = Str::studly($nested ? $nested . '_where' : 'where');

        $this->query = $this->query->{$method}($field, $operator, str_replace('%', '', $value));

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
        return $this->collect($this->query->results());
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

        $path = Request::path();

        $total = array_get($parameters, 'total');
        $perPage   = array_get($parameters, 'per_page', 15);
        $pageName = array_get($parameters, 'page_name', 'page');
        $limitName = array_get($parameters, 'limit_name', 'limit');

        if (!$total) {
            $total = $this->count();
        }

        $page = Request::get($pageName, 1);
        $limit = Request::get($limitName, $perPage);

        $offset = $page * $perPage - $perPage;

        $entries = $this->limit($limit, $offset)->get();

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
     * Create a new entry.
     *
     * @param array $attributes
     * @return EntryInterface
     */
    public function create(array $attributes = [])
    {
        // @todo automatically map to slug or something?
        return $this->make($this->query->get(array_pull($attributes, 'id'))->save($attributes));
    }

    /**
     * Save an entry.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    public function save(EntryInterface $entry)
    {
        $attributes = $entry->getAttributes();

        /**
         * Remove these protected
         * and automated attributes.
         */
        array_pull($attributes, 'id');
        array_pull($attributes, 'created_at');
        array_pull($attributes, 'updated_at');

        return (bool) $this->query
            ->get($entry->id)
            ->save($attributes);
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
        $abstract = $this->stream->attr('abstract', Entry::class);

        return new $abstract($this->stream, $attributes);
    }

    /**
     * Return an entry collection.
     *
     * @param array $entries
     * @return Collection
     */
    protected function collect(array $entries)
    {
        $collection = $this->stream->attr('collection', Collection::class);

        return new $collection(array_map(function ($entry) {
            return $this->make($entry);
        }, $entries));
    }

    /**
     * Return an entry interface from a file.
     *
     * @param $entry
     * @return EntryInterface
     */
    protected function make($entry)
    {
        if ($entry instanceof Document) {

            return $this->newInstance(array_merge(
                [
                    'id' => $entry->getId(),
                    'created_at' => $entry->createdAt(),
                    'updated_at' => $entry->updatedAt(),
                ],
                $entry->toArray()
            ));
        }

        if (is_array($entry)) {
            return $this->newInstance($entry);
        }
    }
}
