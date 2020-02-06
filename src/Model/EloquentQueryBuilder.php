<?php

namespace Anomaly\Streams\Platform\Model;

use Illuminate\Database\Eloquent\Builder;
use Anomaly\Streams\Platform\Traits\Hookable;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Anomaly\Streams\Platform\Traits\HasMemory;
use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

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
    use HasMemory;
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

        return $this->remember($table . $key, function () use ($columns) {

            $this->orderByDefault();

            return parent::get($columns);
        });
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
                } elseif (($field = $model->stream->fields->get($model->stream->getTitleColumn())) && $field->isTranslatable()) {
                    // Need to check for JSON support. SQLite not included.
                    //$this->orderBy($model->stream->getTitleColumn() . '->' . app()->getLocale(), 'ASC');
                } elseif ($model->stream->getTitleColumn() && $model->stream->getTitleColumn() !== 'id') {
                    $query->orderBy($model->stream->getTitleColumn(), 'ASC');
                } else {
                    dd('Tet');
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
