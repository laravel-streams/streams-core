<?php

namespace Anomaly\Streams\Platform\Repository\Contract;

use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

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
     * Return all records.
     *
     * @return Collection
     */
    public function all();

    /**
     * Find a record by it's ID.
     *
     * @param $id
     * @return null|EntryInterface
     */
    //public function find($id);

    /**
     * Find a record by it's column value.
     *
     * @param $column
     * @param $value
     * @return EntryInterface|null
     */
    //public function findBy($column, $value);

    /**
     * Find all records by IDs.
     *
     * @param  array $ids
     * @return Collection
     */
    //public function findAll(array $ids);

    /**
     * Find all by column value.
     *
     * @param $column
     * @param $value
     * @return Collection
     */
    //public function findAllBy($column, $value);

    /**
     * Find a trashed record by it's ID.
     *
     * @param $id
     * @return null|EntryInterface
     */
    //public function findTrashed($id);

    /**
     * Create a new record.
     *
     * @param  array $attributes
     * @return EntryInterface
     */
    //public function create(array $attributes);

    /**
     * Return a new query builder.
     *
     * @return Builder @todo replace correctly
     */
    public function newQuery();

    /**
     * Return a new instance.
     *
     * @param array $attributes
     * @return EntryInterface
     */
    //public function newInstance(array $attributes = []);

    /**
     * Count all records.
     *
     * @return int
     */
    //public function count();

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
     * Save a record.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    //public function save(EntryInterface $entry);

    /**
     * Delete a record.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    //public function delete(EntryInterface $entry);

    /**
     * Force delete a record.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    //public function forceDelete(EntryInterface $entry);

    /**
     * Restore a trashed record.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    //public function restore(EntryInterface $entry);

    /**
     * Truncate the entries.
     *
     * @return $this
     */
    //public function truncate();

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
