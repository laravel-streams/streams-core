<?php

namespace Anomaly\Streams\Platform\Entry;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Anomaly\Streams\Platform\Traits\Hookable;
use Anomaly\Streams\Platform\Traits\HasMemory;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class EntryQueryBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EntryQueryBuilder extends Builder
{
    use Hookable;
    use HasMemory;

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
     * Set the model TTl.
     *
     * @param $ttl
     * @return $this
     */
    public function cache($ttl = null)
    {
        if (!config('streams.database.cache', false)) {
            $this->model->setTtl(0);

            return $this;
        }

        if ($ttl === null) {
            $ttl = config('streams.database.ttl', 3600);
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
     * Order by sort_order if null.
     */
    protected function orderByDefault()
    {
        $model = $this->getModel();
        $query = $this->getQuery();

        if ($query->orders === null) {
            if ($model->stream instanceof StreamInterface) {
                if ($model->stream->sortable) {
                    $query->orderBy($model->getTable() . '.sort_order', 'ASC');
                } elseif (($field = $model->stream->fields->get($model->stream->title_column)) && $field->translatable) {
                    // Need to check for JSON support. SQLite not included.
                    //$this->orderBy($model->stream->title_column . '->' . app()->getLocale(), 'ASC');
                } elseif ($model->stream->title_column && $model->stream->title_column !== 'id') {
                    $query->orderBy($model->stream->title_column, 'ASC');
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
        if ($this->hasHook($hook = Str::snake($method))) {
            return $this->call($hook, $parameters);
        }

        return parent::__call($method, $parameters);
    }
}
