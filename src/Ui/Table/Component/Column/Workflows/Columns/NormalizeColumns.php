<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Column\Workflows\Columns;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class NormalizeColumns
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NormalizeColumns
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $columns = $builder->columns;

        foreach ($columns as $key => &$column) {

            /*
             * @todo clean this up
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
                    'heading' => $key,
                    'value'   => $column,
                ];
            }

            /*
             * If the key is numerical then
             * use it as the header and use the
             * column as the value.
             */
            if (is_numeric($key) && !is_array($column) && !class_exists($column)) {
                $column = [
                    'heading' => ucwords(Str::humanize($column)),
                    'value'   => $column,
                ];
            }

            /*
             * If the column is not already an
             * array then treat it as the value.
             */
            if (!is_array($column)) {
                $column = [
                    'value' => $column,
                ];
            }

            /*
             * If the key is non-numerical and
             * the column is an array without
             * a field then use the key.
             */
            if (!is_numeric($key) && is_array($column) && !array_has($column, 'field')) {
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
             * If no value wrap is set
             * then use a default.
             */
            Arr::set($column, 'wrapper', Arr::get($column, 'wrapper', '{value}'));

            /*
             * If there is no value then use NULL
             */
            Arr::set($column, 'value', Arr::get($column, 'value', null));
        }

        $columns = Normalizer::attributes($columns);

        /**
         * Go back over and assume HREFs.
         * @todo recolumn this - from guesser
         */
        foreach ($columns as $key => &$column) {
            //dd($column);
        }

        $builder->columns = $columns;
    }
}
