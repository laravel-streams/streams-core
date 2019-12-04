<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class FilterInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FilterInput
{

    /**
     * Read the builder's filter input.
     *
     * @param  TableBuilder $builder
     */
    public static function read(TableBuilder $builder)
    {
        self::resolve($builder);
        self::normalize($builder);
        self::merge($builder);

        FilterGuesser::guess($builder);
    }

    /**
     * Resolve input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function resolve(TableBuilder $builder)
    {
        $filters = resolver($builder->getFilters(), compact('builder'));

        $builder->setFilters(evaluate($filters ?: $builder->getFilters(), compact('builder')));
    }

    /**
     * Normalize input.
     *
     * @param TableBuilder $builder
     */
    protected static function normalize(TableBuilder $builder)
    {
        $core = [
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        $filters = $builder->getFilters();
        $stream  = $builder->getTableStream();
        $prefix  = $builder->getTableOption('prefix');

        foreach ($filters as $slug => &$filter) {

            /*
             * If the filter is a string and is
             * not core then use it for everything.
             */
            if (is_string($filter) && !str_contains($filter, '/') && !in_array($filter, $core)) {
                $filter = [
                    'slug'   => $filter,
                    'field'  => $filter,
                    'filter' => 'field',
                ];
            }

            /*
             * If the filter is a string and
             * core then use it for everything.
             */
            if (is_string($filter) && !str_contains($filter, '/') && in_array($filter, $core)) {
                $filter = [
                    'slug'   => $filter,
                    'field'  => $filter,
                    'filter' => $filter,
                ];
            }

            /*
             * If the filter is a class string then use
             * it for the filter.
             */
            if (is_string($filter) && str_contains($filter, '/')) {
                $filter = [
                    'slug'   => $slug,
                    'filter' => $filter,
                ];
            }

            /*
             * Move the slug into the filter.
             */
            if (!isset($filter['slug'])) {
                $filter['slug'] = $slug;
            }

            /*
             * Move the slug to the filter.
             */
            if (!isset($filter['filter'])) {
                $filter['filter'] = $filter['slug'];
            }

            /*
             * Set the prefix if not already set.
             */
            if (!isset($filter['prefix'])) {
                $filter['prefix'] = $prefix;
            }

            /*
             * Fallback the field.
             */
            if (!isset($filter['field']) && $stream && $stream->hasAssignment($filter['slug'])) {
                $filter['field'] = $filter['slug'];
            }

            /*
             * If there is no filter type
             * then assume it's the slug.
             */
            if (!isset($filter['filter'])) {
                $filter['filter'] = $filter['slug'];
            }

            /*
             * Set the table's stream.
             */
            if ($stream) {
                $filter['stream'] = $stream;
            }
        }

        $builder->setFilters($filters);
    }

    /**
     * Merge input.
     *
     * @param TableBuilder $builder
     */
    protected static function merge(TableBuilder $builder)
    {
        $filters = $builder->getFilters();

        foreach ($filters as &$parameters) {

            $filter = array_pull($parameters, 'filter');

            if ($filter && $filter = app(FilterRegistry::class)->get($filter)) {
                $parameters = array_replace_recursive($filter, array_except($parameters, 'filter'));
            }
        }

        $builder->setFilters($filters);
    }
}
