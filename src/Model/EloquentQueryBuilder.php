<?php

namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\Streams\Platform\Traits\Hookable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class EloquentQueryBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class EloquentQueryBuilder extends Builder
{
    use Hookable;
    use DispatchesJobs;

    /**
     * Runtime cache.
     *
     * @var array
     */
    protected static $cache = [];

    /**
     * The model being queried.
     *
     * @var EloquentModel
     */
    protected $model;

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get($columns = ['*'])
    {
        $table = $this->model->getTable();
        $key = md5($this->toSql() . serialize($this->getBindings()));

        if (isset(self::$cache[$table][$key])) {
            return self::$cache[$table][$key];
        }

        $this->orderByDefault();

        return self::$cache[$table][$key] = parent::get($columns);
    }

    /**
     * Return if a table has been joined or not.
     *
     * @param $table
     * @return bool
     */
    public function hasJoin($table)
    {
        if (!$this->query->joins) {
            return false;
        }

        /* @var JoinClause $join */
        foreach ($this->query->joins as $join) {
            if ($join->table === $table) {
                return true;
            }
        }

        return false;
    }

    /**
     * Set the model TTl.
     *
     * @param $ttl
     * @return $this
     */
    public function cache($ttl = null)
    {
        if (!config('streams::database.cache', false)) {
            $this->model->setTtl(0);

            return $this;
        }

        if ($ttl === null) {
            $ttl = config('streams::database.ttl', 3600);
        }

        $this->model->setTtl($ttl);

        return $this;
    }

    /**
     * Get fresh models / disable cache
     *
     * @param  boolean $fresh
     * @return object
     */
    public function fresh($fresh = true)
    {
        if ($fresh) {
            $this->model->setTtl(0);
        }

        return $this;
    }

    /**
     * Update a record in the database.
     *
     * @param  array $values
     * @return int
     */
    public function update(array $values)
    {
        $this->model->fireEvent('updatingMultiple');

        $return = parent::update($values);

        $this->model->fireEvent('updatedMultiple');

        return $return;
    }

    /**
     * Delete a record from the database.
     *
     * @return mixed
     */
    public function delete()
    {
        $this->model->fireEvent('deletingMultiple');

        $return = parent::delete();

        $this->model->fireEvent('deletedMultiple');

        return $return;
    }

    /**
     * Order by sort_order if null.
     */
    protected function orderByDefault()
    {
        $model = $this->getModel();
        $query = $this->getQuery();

        if ($query->orders === null) {
            if ($model instanceof EntryInterface) {
                if ($model->stream->isSortable()) {
                    $query->orderBy($model->getTable() . '.sort_order', 'ASC');
                } elseif ($model->titleColumnIsTranslatable()) {
                    $this->orderBy($model->getTitleName() . '->' . app()->getLocale(), 'ASC');
                } elseif ($model->getTitleName() && $model->getTitleName() !== 'id') {
                    $query->orderBy($model->getTitleName(), 'ASC');
                }
            }
        }
    }

    /**
     * Find a record by it's column value.
     *
     * @param $column
     * @param $value
     * @return EloquentModel|null
     */
    public function findBy($column, $value)
    {
        return $this->model->where($column, $value)->first();
    }

    /**
     * Select the default columns.
     *
     * This is helpful when using addSelect
     * elsewhere like in a hook/criteria and
     * that select ends up being all you select.
     *
     * @return $this
     */
    public function selectDefault()
    {
        if (!$this->query->columns && $this->query->from) {
            $this->query->select($this->query->from . '.*');
        }

        return $this;
    }

    /**
     * Add hookable catch to the query builder system.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if ($this->hasHook($hook = snake_case($method))) {
            return $this->call($hook, $parameters);
        }

        return parent::__call($method, $parameters);
    }
}
