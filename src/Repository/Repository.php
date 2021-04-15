<?php

namespace Streams\Core\Repository;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Streams\Core\Criteria\Criteria;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Criteria\Adapter\FileAdapter;
use Streams\Core\Criteria\Adapter\SelfAdapter;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Core\Criteria\Adapter\DatabaseAdapter;
use Streams\Core\Criteria\Adapter\EloquentAdapter;
use Streams\Core\Criteria\Adapter\FilebaseAdapter;
use Streams\Core\Criteria\Contract\CriteriaInterface;
use Streams\Core\Repository\Contract\RepositoryInterface;

class Repository implements RepositoryInterface
{

    use Macroable;
    use HasMemory;
    use FiresCallbacks;

    /**
     * The stream instance.
     *
     * @var Stream
     */
    protected $stream;

    /**
     * Create a new Repository instance.
     *
     * @param Stream $stream
     */
    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
    }

    /**
     * Return all entries.
     *
     * @return Collection
     */
    public function all()
    {
        return $this
            ->newCriteria()
            ->all();
    }

    /**
     * Find an entry by ID.
     *
     * @param $id
     * @return null|EntryInterface
     */
    public function find($id)
    {
        return $this
            ->newCriteria()
            ->find($id);
    }

    /**
     * Find all records by IDs.
     *
     * @param  array $ids
     * @return Collection
     */
    public function findAll(array $ids)
    {
        return $this
            ->newCriteria()
            ->where('id', 'IN', $ids)
            ->get();
    }

    /**
     * Find an entry by a field value.
     *
     * @param $field
     * @param $value
     * @return EntryInterface|null
     */
    public function findBy($field, $value)
    {
        return $this
            ->newCriteria()
            ->where($field, $value)
            ->first();
    }

    /**
     * Find all entries by field value.
     * 
     * @param $field
     * @param $operator
     * @param $value
     * @return Collection
     */
    public function findAllWhere($field, $operator, $value = null)
    {
        return $this
            ->newCriteria()
            ->where($field, $operator, $value)
            ->get();
    }

    /**
     * Create a new entry.
     *
     * @param  array $attributes
     * @return EntryInterface
     */
    public function create(array $attributes)
    {
        $this->fire($this->stream->handle . '.creating', [
            'attributes' => $attributes,
        ]);

        $result =  $this
            ->newCriteria()
            ->create($attributes); // @todo Should instantiate and use save?

        $this->fire($this->stream->handle . '.created', [
            'entry' => $result,
        ]);

        return $result;
    }

    /**
     * Save an entry.
     *
     * @param  $entry
     * @return bool
     */
    public function save($entry)
    {
        $this->fire($this->stream->handle . '.saving', [
            'entry' => $entry,
        ]);

        $result = $this
            ->newCriteria()
            ->save($entry);

        $this->fire($this->stream->handle . '.saved', [
            'entry' => $entry,
        ]);

        return $result;
    }

    /**
     * Delete an entry.
     *
     * @param $entry
     * @return bool
     */
    public function delete($entry)
    {
        $this->fire($this->stream->handle . '.deleting', [
            'entry' => $entry,
        ]);

        $id = is_object($entry) ? $entry->id : $entry;

        $result = $this
            ->newCriteria()
            ->where('id', $id)
            ->delete();

        $this->fire($this->stream->handle . '.deleted', [
            'entry' => $entry,
        ]);

        return $result;
    }

    /**
     * Truncate all entries.
     *
     * @return bool
     */
    public function truncate()
    {
        $this->fire($this->stream->handle . '.truncating');

        $result = $this
            ->newCriteria()
            ->truncate();

        $this->fire($this->stream->handle . '.truncated');

        return $result;
    }

    /**
     * Return a new instance.
     *
     * @param array $attributes
     * @return EntryInterface
     */
    public function newInstance(array $attributes = [])
    {
        return $this
            ->newCriteria()
            ->newInstance($attributes);
    }

    /**
     * Return a new entry criteria.
     *
     * @return CriteriaInterface
     */
    public function newCriteria()
    {
        $default = Config::get('streams.core.default_source', 'filebase');
        $criteria = $this->stream->criteria ?: Criteria::class;

        $adapter = Arr::get($this->stream->source, 'adapter');

        $default = Str::camel("new_{$this->stream->expandPrototypeAttribute('source')->get('type',$default)}_adapter");

        return new $criteria($adapter ? new $adapter($this->stream) : $this->$default(), $this->stream);
    }

    /**
     * Return a new self criteria.
     * 
     * @return SelfAdapter
     */
    public function newSelfAdapter()
    {
        return new SelfAdapter($this->stream);
    }

    /**
     * Return a new file criteria.
     * 
     * @return FileAdapter
     */
    public function newFileAdapter()
    {
        return new FileAdapter($this->stream);
    }

    /**
     * Return a new filebase criteria.
     * 
     * @return FilebaseAdapter
     */
    public function newFilebaseAdapter()
    {
        return new FilebaseAdapter($this->stream);
    }

    /**
     * Return a new database criteria.
     * 
     * @return DatabaseAdapter
     */
    public function newDatabaseAdapter()
    {
        return new DatabaseAdapter($this->stream);
    }

    /**
     * Return a new filebase criteria.
     * 
     * @return EloquentAdapter
     */
    public function newEloquentAdapter()
    {
        return new EloquentAdapter($this->stream);
    }
}
