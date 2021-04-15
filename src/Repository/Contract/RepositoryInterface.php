<?php

namespace Streams\Core\Repository\Contract;

use Illuminate\Support\Collection;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Criteria\Contract\CriteriaInterface;

/**
 * Interface RepositoryInterface
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
interface RepositoryInterface
{

    /**
     * Return all entries.
     *
     * @return Collection
     */
    public function all();

    /**
     * Find an entry by ID.
     *
     * @param $id
     * @return null|EntryInterface
     */
    public function find($id);

    /**
     * Find all entries by IDs.
     *
     * @param  array $ids
     * @return Collection
     */
    public function findAll(array $ids);

    /**
     * Find an entry by a field value.
     *
     * @param $field
     * @param $value
     * @return EntryInterface|null
     */
    public function findBy($field, $value);

    /**
     * Find all entries by field value.
     *
     * @param $field
     * @param $operator
     * @param $value
     * @return Collection
     */
    public function findAllWhere($field, $operator, $value = null);

    /**
     * Find a trashed entry by it's ID.
     *
     * @param $id
     * @return null|EntryInterface
     */
    //public function findTrashed($id);

    /**
     * Create a new entry.
     *
     * @param  array $attributes
     * @return EntryInterface
     */
    public function create(array $attributes);

    /**
     * Save an entry.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    public function save(EntryInterface $entry);

    /**
     * Delete an entry.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    public function delete(EntryInterface $entry);

    /**
     * Force delete an entry.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    //public function forceDelete(EntryInterface $entry);

    /**
     * Restore a trashed entry.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    //public function restore(EntryInterface $entry);

    /**
     * Truncate the entries.
     *
     * @return void
     */
    public function truncate();

    /**
     * Return a new instance.
     *
     * @param array $attributes
     * @return EntryInterface
     */
    public function newInstance(array $attributes = []);

    /**
     * Return a new entry criteria.
     *
     * @return CriteriaInterface
     */
    public function newCriteria();

    /**
     * Return a paginated collection.
     *
     * @param  array $parameters
     * @return LengthAwarePaginator
     */
    //public function paginate(array $parameters = []);

    /**
     * Return the last modified entry.
     *
     * @return EntryInterface|null
     */
    //public function lastModified();

    /**
     * Cache a value in the
     * model's cache collection.
     *
     * @param $key
     * @param $ttl
     * @param null $value
     * @return mixed
     */
    ////public function cache($key, $ttl, $value = null);

    /**
     * Cache (forever) a value in
     * the model's cache collection.
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    ////public function cacheForever($key, $value);
}
