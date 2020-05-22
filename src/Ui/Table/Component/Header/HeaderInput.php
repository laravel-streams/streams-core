<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class HeaderInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class HeaderInput
{

    /**
     * Read builder header input.
     *
     * @param  TableBuilder $builder
     * @return array
     */
    public static function read(TableBuilder $builder)
    {
        self::resolve($builder);
        self::defaults($builder);
        self::normalize($builder);

        HeaderGuesser::guess($builder);

        self::translate($builder);
        self::parse($builder);
    }

    /**
     * Resolve input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function resolve(TableBuilder $builder)
    {
        $columns = resolver($builder->views, compact('builder'));

        $builder->views = evaluate($columns ?: $builder->views, compact('builder'));
    }

    /**
     * Default input.
     *
     * @param TableBuilder $builder
     */
    protected static function defaults(TableBuilder $builder)
    {
        if (!$stream = $builder->stream) {
            return;
        }

        if ($builder->columns == []) {
            $builder->columns = [$stream->title_column];
        }
    }

    /**
     * Normalize input.
     *
     * @param TableBuilder $builder
     */
    protected static function normalize(TableBuilder $builder)
    {
        $columns = $builder->columns;

        foreach ($columns as $key => &$column) {

            /*
             * If the key is non-numerical then
             * use it as the header and use the
             * column as the column if it's a class.
             */
            if (!is_numeric($key) && !is_array($column) && class_exists($column)) {
                $column = [
                    'heading' => $key,
                    'column'  => $column,
                ];
            }

            /*
             * If the key is non-numerical then
             * use it as the header and use the
             * column as the value.
             */
            if (!is_numeric($key) && !is_array($column) && !class_exists($column)) {
                $column = [
                    'value' => $column,
                    'field' => $key,
                ];
            }

            /*
             * If the column is just a string then treat
             * it as the header AND the value.
             */
            if (is_string($column)) {
                $column = [
                    'field' => $column,
                    'value' => $column,
                ];
            }

            /*
             * If the key is non-numerical and
             * the column is an array without
             * a heading then use the key.
             */
            if (!is_numeric($key) && is_array($column) && !isset($column['field'])) {
                $column['field'] = $key;
            }

            /*
             * If the key is non-numerical and
             * the column is an array without
             * a value then use the key.
             */
            if (!is_numeric($key) && is_array($column) && !isset($column['value'])) {
                $column['value'] = $key;
            }

            /*
             * If there is no value then use NULL
             */
            array_set($column, 'value', array_get($column, 'value', null));
        }

        $builder->columns = $columns;
    }

    /**
     * Parse input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function parse(TableBuilder $builder)
    {
        $builder->columns = Arr::parse($builder->columns);
    }

    /**
     * Translate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function translate(TableBuilder $builder)
    {
        $builder->columns = translate($builder->columns);
    }
}
