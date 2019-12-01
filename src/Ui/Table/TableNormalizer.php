<?php

namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;

/**
 * Class TableNormalizer
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TableNormalizer extends Normalizer
{

    /**
     * Normalize actions.
     *
     * @param array $actions
     * @param string $prefix
     */
    public static function actions(array $actions)
    {
        foreach ($actions as $slug => &$action) {

            /*
            * If the slug is numeric and the action is
            * a string then treat the string as both the
            * action and the slug. This is OK as long as
            * there are not multiple instances of this
            * input using the same action which is not likely.
            */
            if (is_numeric($slug) && is_string($action)) {
                $action = [
                    'slug'   => $action,
                    'action' => $action,
                ];
            }

            /*
            * If the slug is NOT numeric and the action is a
            * string then use the slug as the slug and the
            * action as the action.
            */
            if (!is_numeric($slug) && is_string($action)) {
                $action = [
                    'slug'   => $slug,
                    'action' => $action,
                ];
            }

            /*
            * If the slug is not numeric and the action is an
            * array without a slug then use the slug for
            * the slug for the action.
            */
            if (is_array($action) && !isset($action['slug']) && !is_numeric($slug)) {
                $action['slug'] = $slug;
            }

            /*
            * If the slug is not numeric and the action is an
            * array without a action then use the slug for
            * the action for the action.
            */
            if (is_array($action) && !isset($action['action']) && !is_numeric($slug)) {
                $action['action'] = $slug;
            }

            /*
            * Make sure the HREF is absolute.
            */
            if (
                isset($action['redirect']) &&
                is_string($action['redirect']) &&
                !starts_with($action['redirect'], ['http', '{url.'])
            ) {
                $action['redirect'] = url($action['redirect']);
            }
        }

        return $actions;
    }

    /**
     * Normalize buttons.
     *
     * @param array $buttons
     * @param string $prefix
     */
    public static function buttons(array $buttons)
    {
        foreach ($buttons as $key => &$button) {

            /**
             * If the button is a string then use
             * it as the button parameter.
             */
            if (is_string($button)) {
                $button = [
                    'button' => $button,
                ];
            }

            /**
             * If the key is a string and the button
             * is an array without a button param then
             * move the key into the button as that param.
             */
            if (!is_integer($key) && !isset($button['button'])) {
                $button['button'] = $key;
            }
        }

        return $buttons;
    }

    /**
     * Normalize filters.
     *
     * @param array $filters
     * @param string $prefix
     */
    public static function filters(array $filters, StreamInterface $stream = null)
    {
        $core = [
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

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

        return $filters;
    }

    /**
     * Normalize headers.
     *
     * @param array $headers
     */
    public static function headers(array $columns)
    {
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

        return $columns;
    }

    /**
     * Normalize columns.
     *
     * @param array $columns
     */
    public static function columns(array $columns)
    {
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

        return $columns;
    }
}
