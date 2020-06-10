<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Illuminate\Support\Str;
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

        self::translate($builder);
    }

    /**
     * Resolve input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function resolve(TableBuilder $builder)
    {
        $filters = resolver($builder->filters, compact('builder'));

        $builder->filters = evaluate($filters ?: $builder->filters, compact('builder'));
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

        $stream  = $builder->stream;
        $filters = $builder->filters;
        $prefix  = $builder->table->options->get('prefix');

        foreach ($filters as $slug => &$filter) {

            /*
             * If the filter is a string and is
             * not core then use it for everything.
             */
            if (is_string($filter) && !Str::contains($filter, '/') && !in_array($filter, $core)) {
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
            if (is_string($filter) && !Str::contains($filter, '/') && in_array($filter, $core)) {
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
            if (is_string($filter) && Str::contains($filter, '/')) {
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
            if (!isset($filter['field']) && $stream && $stream->fields->has($filter['slug'])) {
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

        $builder->filters = $filters;
    }

    /**
     * Merge input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function merge(TableBuilder $builder)
    {
        $filters = $builder->filters;

        foreach ($filters as &$parameters) {

            $filter = array_pull($parameters, 'filter');

            if ($filter && $filter = app(FilterRegistry::class)->get($filter)) {
                $parameters = array_replace_recursive($filter, array_except($parameters, 'filter'));
            }
        }

        $builder->filters = $filters;
    }

    /**
     * Translate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function translate(TableBuilder $builder)
    {
        $builder->filters = translate($builder->filters);
    }
}
