<?php

namespace Anomaly\Streams\Platform\Model\Traits;

/**
 * Class ProvidesQueryBuilders
 *
 * @property array $stream
 * 
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait ProvidesQueryBuilders
{

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        if (isset($this->builder) && is_string($this->builder)) {
            return $this->builder;
        }
        
        $builder = $this->getQueryBuilderName();

        return new $builder($query);
    }

    /**
     * Get the router name.
     *
     * @return string
     */
    public function getQueryBuilderName()
    {
        $builder = substr(get_class($this), 0, -5) . 'QueryBuilder';

        return class_exists($builder) ? $builder : \Anomaly\Streams\Platform\Entry\EntryQueryBuilder::class;
    }
}
