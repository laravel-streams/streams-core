<?php

namespace Anomaly\Streams\Platform\Entry;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Anomaly\Streams\Platform\Stream\Stream;
use Anomaly\Streams\Platform\Traits\Hookable;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;

/**
 * Class EntryRepository
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EntryRepository implements EntryRepositoryInterface
{

    use Hookable;
    use FiresCallbacks;

    /**
     * Return all records.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Return all records with trashed.
     *
     * @return Collection
     */
    public function allWithTrashed()
    {
        return $this->model->withTrashed()->get();
    }

    /**
     * Find a record by it's ID.
     *
     * @param $id
     * @return EntryInterface
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Find a record by it's column value.
     *
     * @param $column
     * @param $value
     * @return EntryInterface|null
     */
    public function findBy($column, $value)
    {
        return $this->model->where($column, $value)->first();
    }

    /**
     * Find all records by IDs.
     *
     * @param  array $ids
     * @return Collection
     */
    public function findAll(array $ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    /**
     * Find all by column value.
     *
     * @param $column
     * @param $value
     * @return Collection
     */
    public function findAllBy($column, $value)
    {
        return $this->model->where($column, $value)->get();
    }

    /**
     * Find a trashed record by it's ID.
     *
     * @param $id
     * @return null|EntryInterface
     */
    public function findTrashed($id)
    {
        return $this->model
            ->withTrashed()
            ->orderBy('id', 'ASC')
            ->where('id', $id)
            ->first();
    }

    /**
     * Create a new record.
     *
     * @param  array $attributes
     * @return EntryInterface
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Return a new query builder.
     *
     * @return Builder
     */
    public function newQuery()
    {
        return $this->model->newQuery();
    }

    /**
     * Return a new instance.
     *
     * @param array $attributes
     * @return EntryInterface
     */
    public function newInstance(array $attributes = [])
    {
        return $this->model->newInstance($attributes);
    }

    /**
     * Count all records.
     *
     * @return int
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * Return a paginated collection.
     *
     * @param  array $parameters
     * @return LengthAwarePaginator
     */
    public function paginate(array $parameters = [])
    {
        $paginator = Arr::pull($parameters, 'paginator');
        $perPage   = Arr::pull($parameters, 'per_page', config('streams.system.per_page', 15));

        /* @var Builder $query */
        $query = $this->model->newQuery();

        /*
         * First apply any desired scope.
         */
        if ($scope = Arr::pull($parameters, 'scope')) {
            call_user_func([$query, camel_case($scope)], Arr::pull($parameters, 'scope_arguments', []));
        }

        /*
         * Lastly we need to loop through all of the
         * parameters and assume the rest are methods
         * to call on the query builder.
         */
        foreach ($parameters as $method => $arguments) {
            $method = camel_case($method);

            if (in_array($method, ['update', 'delete'])) {
                continue;
            }

            if (is_array($arguments)) {
                call_user_func_array([$query, $method], $arguments);
            } else {
                call_user_func_array([$query, $method], [$arguments]);
            }
        }

        if ($paginator === 'simple') {
            $pagination = $query->simplePaginate($perPage);
        } else {
            $pagination = $query->paginate($perPage);
        }

        return $pagination;
    }

    /**
     * Return the last modified entry.
     *
     * @return EntryInterface|null
     */
    public function lastModified()
    {
        return $this->model
            ->orderBy('updated_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->first();
    }

    /**
     * Save a record.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    public function save(EntryInterface $entry)
    {
        return $entry->save();
    }

    /**
     * Delete a record.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    public function delete(EntryInterface $entry)
    {
        return $entry->delete();
    }

    /**
     * Force delete a record.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    public function forceDelete(EntryInterface $entry)
    {
        $entry->forceDelete();

        /*
         * If we were not able to force delete
         */

        return !$entry->exists;
    }

    /**
     * Restore a trashed record.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    public function restore(EntryInterface $entry)
    {
        return $entry->restore();
    }

    /**
     * Truncate the entries.
     *
     * @return $this
     */
    public function truncate()
    {
        $this->truncateModel($this->model);

        return $this;
    }

    /**
     * Cache a value in the
     * model's cache collection.
     *
     * @param $key
     * @param $ttl
     * @param $value
     * @return mixed
     */
    // public function cache($key, $ttl, $value = null)
    // {
    //     return $this->model->cache($key, $ttl, $value);
    // }

    /**
     * Cache a value in the
     * model's cache collection.
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    // public function cacheForever($key, $value)
    // {
    //     return $this->model->cacheForever($key, $value);
    // }

    /**
     * Set the stream.
     *
     * @param  Stream $model
     * @return $this
     */
    public function setModel(EntryInterface $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the model.
     *
     * @return EntryInterface
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Pipe non-existing calls through hooks.
     *
     * @param $method
     * @param $parameters
     * @return mixed|null
     */
    public function __call($method, $parameters)
    {
        if ($this->hasHook($hook = Str::snake($method))) {
            return $this->call($hook, $parameters);
        }

        return null;
    }
}
