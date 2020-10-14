<?php

namespace Streams\Core\Repository;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Criteria\DatabaseCriteria;
use Streams\Core\Criteria\EloquentCriteria;
use Streams\Core\Criteria\FilebaseCriteria;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Core\Criteria\Contract\CriteriaInterface;
use Streams\Core\Repository\Contract\RepositoryInterface;

/**
 * Class Repository
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
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
     * Count all entries.
     *
     * @return int
     */
    public function count()
    {
        return $this
            ->newCriteria()
            ->count();
    }

    /**
     * Create a new entry.
     *
     * @param  array $attributes
     * @return EntryInterface
     */
    public function create(array $attributes)
    {
        return $this
            ->newCriteria()
            ->create($attributes);
    }

    /**
     * Save an entry.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    public function save(EntryInterface $entry)
    {
        return $this
            ->newCriteria()
            ->save($entry);
    }

    /**
     * Delete an entry.
     *
     * @param EntryInterface $entry
     * @return bool
     */
    public function delete(EntryInterface $entry)
    {
        return $this
            ->newCriteria()
            ->delete($entry);
    }

    /**
     * Truncate all entries.
     *
     * @return bool
     */
    public function truncate()
    {
        return $this
            ->newCriteria()
            ->truncate();
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
        $default = Config::get('streams.sources.default', 'filebase');

        $method = Str::camel("new_{$this->stream->expandPrototypeAttribute('source')->get('type', $default)}_criteria");
        
        return $this->$method();
    }

    /**
     * Return a new filebase criteria.
     * 
     * @return FilebaseCriteria
     */
    public function newFilebaseCriteria()
    {
        return new FilebaseCriteria($this->stream);
    }

    /**
     * Return a new database criteria.
     * 
     * @return DatabaseCriteria
     */
    public function newDatabaseCriteria()
    {
        return new DatabaseCriteria($this->stream);
    }

    /**
     * Return a new filebase criteria.
     * 
     * @return EloquentCriteria
     */
    public function newEloquentCriteria()
    {
        return new EloquentCriteria($this->stream);
    }
}
