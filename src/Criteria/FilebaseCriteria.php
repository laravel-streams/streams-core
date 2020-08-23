<?php

namespace Anomaly\Streams\Platform\Criteria;

use Filebase\Database;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Entry\Entry;
use Anomaly\Streams\Platform\Stream\Stream;
use Illuminate\Pagination\LengthAwarePaginator;
use Anomaly\Streams\Platform\Support\Traits\HasMemory;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
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
     * Create a new class instance.
     *
     * @param Stream $stream
     */
    public function __construct(Stream $stream)
    {
        $this->stream = $stream;

        $source = $stream->expand('source');

        $this->query = new Database([
            'dir' => base_path($source->get('path', 'streams/data/' . $stream->handle)),

            //'backupLocation' => 'path/to/database/backup/dir',
            'format'         => Config::get('streams.sources.types.filebase.formats.' . $source->get('format', 'md')),
            'cache'          => $source->get('cache', false),
            'cache_expires'  => $source->get('ttl', 1800),
            'pretty'         => true,
            'safe_filename'  => true,
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
        return $this
            ->limit(1, 0)
            ->get()
            ->first();
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

        $operator = strtoupper($operator);

        if ($field == 'id') {
            $field = '__id';
        }

        $method = $nested ? Str::studly($nested . '_where') : 'where';

        if (is_string($value) && $operator == 'like') {
            $value = str_replace('%', '', $value); // Filebase doesn't use "%"
        }

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
        return $this->collect($this->query->resultDocuments());
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
     * Create a new entry.
     *
     * @param array $attributes
     * @return EntryInterface
     */
    public function create(array $attributes = [])
    {
        $id = Arr::pull($attributes, 'id');

        if ($this->query->has($id)) {
            throw new \Exception("Entry with ID [{$id}] already exists.");
        }

        $document = $this->query->get($id);

        if (!$document->save($attributes)) {
            return false;
        }

        return $this->make($document);
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
        Arr::pull($attributes, 'id');
        Arr::pull($attributes, 'created_at');
        Arr::pull($attributes, 'updated_at');

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
        return $this->newInstance(array_merge(
            [
                'id' => $entry->getId(),
                'created_at' => $entry->createdAt(),
                'updated_at' => $entry->updatedAt(),
            ],
            $entry->toArray()
        ));
    }
}
