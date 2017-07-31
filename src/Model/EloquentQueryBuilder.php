<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Collection\CacheCollection;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\Streams\Platform\Traits\Hookable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
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
        $key = $this->getCacheKey();

        if (
            env('INSTALLED')
            && PHP_SAPI != 'cli'
            && env('DB_CACHE') !== false
            && $this->model instanceof EntryModel
            && isset(self::$cache[$this->model->getCacheCollectionKey()][$key])
        ) {
            return self::$cache[$this->model->getCacheCollectionKey()][$key];
        }

        $this->orderByDefault();

        if (PHP_SAPI != 'cli' && env('DB_CACHE') !== false && $this->model->getTtl()) {

            $this->rememberIndex();

            try {
                return app('cache')->remember(
                    $this->getCacheKey(),
                    $this->model->getTtl(),
                    function () use ($columns) {
                        return parent::get($columns);
                    }
                );
            } catch (\Exception $e) {
                return parent::get($columns);
            }
        }

        return self::$cache[$this->model->getCacheCollectionKey()][$key] = parent::get($columns);
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
     * Remember and index.
     *
     * @return $this
     */
    protected function rememberIndex()
    {
        if ($this->model->getTtl()) {
            $this->indexCacheCollection();
        }

        return $this;
    }

    /**
     * Index cache collection
     *
     * @return object
     */
    protected function indexCacheCollection()
    {
        (new CacheCollection())
            ->make([$this->getCacheKey()])
            ->setKey($this->model->getCacheCollectionKey())
            ->index();

        return $this;
    }

    /**
     * Drop a cache collection
     * from runtime cache.
     *
     * @param $collection
     */
    public static function dropRuntimeCache($collection)
    {
        unset(self::$cache[$collection]);
    }

    /**
     * Get the unique cache key for the query.
     *
     * @return string
     */
    public function getCacheKey()
    {
        $name = $this->model->getConnectionName();

        return md5($name . $this->toSql() . serialize($this->getBindings()));
    }

    /**
     * Set the model TTl.
     *
     * @param $ttl
     * @return $this
     */
    public function cache($ttl)
    {
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
            if ($model instanceof AssignmentModel) {
                $query->orderBy('streams_assignments.sort_order', 'ASC');
            } elseif ($model instanceof StreamModel && env('INSTALLED')) { // Ensure migrations are complete.
                $query->orderBy('streams_streams.sort_order', 'ASC');
            } elseif ($model instanceof EntryInterface) {
                if ($model->getStream()->isSortable()) {
                    $query->orderBy('sort_order', 'ASC');
                } elseif ($model->titleColumnIsTranslatable()) {

                    /**
                     * Postgres makes it damn near impossible
                     * to order by a foreign column and retain
                     * distinct results so let's avoid it entirely.
                     *
                     * Sorry!
                     */
                    if (env('DB_CONNECTION', 'mysql') == 'pgsql') {
                        return;
                    }

                    if (!$this->hasJoin($model->getTranslationsTableName())) {
                        $this->query->leftJoin(
                            $model->getTranslationsTableName(),
                            $model->getTableName() . '.id',
                            '=',
                            $model->getTranslationsTableName() . '.entry_id'
                        );
                    }

                    $this
                        ->groupBy($model->getTableName() . '.id')
                        ->select($model->getTableName() . '.*')
                        ->where(
                            function (Builder $query) use ($model) {
                                $query->where($model->getTranslationsTableName() . '.locale', config('app.locale'));
                                $query->orWhere(
                                    $model->getTranslationsTableName() . '.locale',
                                    config('app.fallback_locale')
                                );
                                $query->orWhereNull($model->getTranslationsTableName() . '.locale');
                            }
                        )
                        ->orderBy($model->getTranslationsTableName() . '.' . $model->getTitleName(), 'ASC');
                } elseif ($model->getTitleName() && $model->getTitleName() !== 'id') {
                    $query->orderBy($model->getTitleName(), 'ASC');
                }
            }
        }
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
