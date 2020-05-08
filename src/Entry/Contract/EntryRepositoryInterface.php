<?php

namespace Anomaly\Streams\Platform\Entry\Contract;

use Illuminate\Database\Eloquent\Model;
use Anomaly\Streams\Platform\Entry\EntryCollection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

/**
 * Interface EntryRepositoryInterface
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
interface EntryRepositoryInterface
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
    public function find($id);

    /**
     * Find a record by it's column value.
     *
     * @param $column
     * @param $value
     * @return EntryInterface|null
     */
    public function findBy($column, $value);

    /**
     * Find all records by IDs.
     *
     * @param  array $ids
     * @return Collection
     */
    public function findAll(array $ids);

    /**
     * Find all by column value.
     *
     * @param $column
     * @param $value
     * @return Collection
     */
    public function findAllBy($column, $value);

    /**
     * Find a trashed record by it's ID.
     * 
     * @todo Do we want findTrashedBy and findAllTrashedBy?
     *
     * @param $id
     * @return null|EntryInterface
     */
    public function findTrashed($id);

    /**
     * Create a new record.
     *
     * @param  array $attributes
     * @return EntryInterface
     */
    public function create(array $attributes);

    /**
     * Return a new query builder.
     *
     * @return Builder
     */
    public function newQuery();

    /**
     * Return a new instance.
     *
     * @param array $attributes
     * @return EntryInterface
     */
    public function newInstance(array $attributes = []);

    /**
     * Count all records.
     *
     * @return int
     */
    public function count();

    /**
     * Return a paginated collection.
     *
     * @param  array $parameters
     * @return LengthAwarePaginator
     */
    public function paginate(array $parameters = []);

    /**
     * Save a record.
     *
     * @param  Model $entry
     * @return bool
     */
    public function save(Model $entry);

    /**
     * Delete a record.
     *
     * @param  Model $entry
     * @return bool
     */
    public function delete(Model $entry);

    /**
     * Force delete a record.
     *
     * @param  Model $entry
     * @return bool
     */
    public function forceDelete(Model $entry);

    /**
     * Restore a trashed record.
     *
     * @param  Model $entry
     * @return bool
     */
    public function restore(Model $entry);

    /**
     * Truncate the entries.
     *
     * @return $this
     */
    public function truncate();

    /**
     * Cache a value in the
     * model's cache collection.
     *
     * @param $key
     * @param $ttl
     * @param null $value
     * @return mixed
     */
    //public function cache($key, $ttl, $value = null);

    /**
     * Cache (forever) a value in
     * the model's cache collection.
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    //public function cacheForever($key, $value);

    /**
     * Set the repository model.
     *
     * @param  Model $model
     * @return $this
     */
    public function setModel(Model $model);

    /**
     * Get the model.
     *
     * @return EntryInterface
     */
    public function getModel();

    /**
     * Return the last modified entry.
     *
     * @return EntryInterface|null
     */
    public function lastModified();
}
