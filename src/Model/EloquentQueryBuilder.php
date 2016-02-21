<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Collection\CacheCollection;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Database\Query\JoinClause;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class EloquentQueryBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Model
 */
class EloquentQueryBuilder extends Builder
{

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
        $this->orderByDefault();

        if (!env('APP_DEBUG') || env('DB_CACHE')) {

            $this->rememberIndex();

            if ($this->model->getTtl()) {
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
        }

        return parent::get($columns);
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
     * @param array $values
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
                $query->orderBy('sort_order', 'ASC');
            } elseif ($model instanceof EntryInterface) {
                if ($model->getStream()->isSortable()) {
                    $query->orderBy('sort_order', 'ASC');
                } elseif ($model->titleColumnIsTranslatable()) {

                    if (!$this->hasJoin($model->getTranslationsTableName())) {
                        $this->query->leftJoin(
                            $model->getTranslationsTableName(),
                            $model->getTableName() . '.id',
                            '=',
                            $model->getTranslationsTableName() . '.entry_id'
                        );

                        $this->where($model->getTranslationsTableName() . '.locale', config('app.fallback_locale'));
                    }

                    $query->orderBy($model->getTitleName(), 'ASC');
                } elseif ($model->getTitleName() && $model->getTitleName() !== 'id') {
                    $query->orderBy($model->getTitleName(), 'ASC');
                }
            }
        }
    }
}
