<?php namespace Anomaly\Streams\Platform\Entry\Contract;

use Anomaly\Streams\Platform\Entry\EntryCollection;
use Illuminate\Database\Eloquent\Model;

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
     * Return all records with trashed.
     *
     * @return Collection
     */
    public function allWithTrashed();

    /**
     * Return all records without relations.
     *
     * @return Collection
     */
    public function allWithoutRelations();

    /**
     * Find a record by it's ID.
     *
     * @param $id
     * @return null|Model
     */
    public function find($id);

    /**
     * Return all records without relations.
     *
     * @param $id
     * @return Model
     */
    public function findWithoutRelations($id);

    /**
     * Find a record by it's column value.
     *
     * @param $column
     * @param $value
     * @return Model|null
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
     * @param $id
     * @return null|Model
     */
    public function findTrashed($id);

    /**
     * Create a new record.
     *
     * @param  array $attributes
     * @return Model
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
     * @return Model
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
     * Perform an action without events.
     *
     * @param  Model $entry
     * @param \Closure $closure
     * @return mixed
     */
    public function withoutEvents(\Closure $closure);

    /**
     * Save a record.
     *
     * @param  Model $entry
     * @return bool
     */
    public function save(Model $entry);

    /**
     * Update multiple records.
     *
     * @param  array $attributes
     * @return bool
     */
    public function update(array $attributes = []);

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
    public function cache($key, $ttl, $value = null);

    /**
     * Cache (forever) a value in
     * the model's cache collection.
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function cacheForever($key, $value);

    /**
     * Guard the model.
     *
     * @return $this
     */
    public function guard();

    /**
     * Unguard the model.
     *
     * @return $this
     */
    public function unguard();

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
     * @return Model
     */
    public function getModel();

    /**
     * Get the entries by sort order.
     *
     * @param  string                 $direction
     * @return EntryCollection
     */
    public function sorted($direction = 'asc');

    /**
     * Get the first entry
     * by it's sort order.
     *
     * @param  string              $direction
     * @return EntryInterface|null
     */
    public function first($direction = 'asc');

    /**
     * Return the last modified entry.
     *
     * @return EntryInterface|null
     */
    public function lastModified();
}
