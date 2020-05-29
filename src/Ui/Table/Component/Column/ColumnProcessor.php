<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

use Anomaly\Streams\Platform\Ui\Support\Processor;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ColumnProcessor
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ColumnProcessor extends Processor
{

    /**
     * Read the builder's column input.
     * 
     * @return $this
     */
    public function normalize()
    {
        $columns = $this->builder->parent->columns;

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
            array_set($column, 'wrapper', array_get($column, 'wrapper', '{value}'));

            /*
             * If there is no value then use NULL
             */
            array_set($column, 'value', array_get($column, 'value', null));
        }

        $this->builder->parent->columns = $columns;

        return $this;
    }
}
