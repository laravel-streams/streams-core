<?php

namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Support\Normalizer;

/**
 * Class FormNormalizer
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FormNormalizer extends Normalizer
{

    /**
     * Normalize fields.
     *
     * @param array $fields
     */
    public static function fields(array $fields)
    {

        foreach ($fields as $slug => &$field) {

            /*
             * If the field is a wild card marker
             * then just continue.
             */
            if ($field == '*') {
                continue;
            }

            /*
             * If the slug is numeric and the field
             * is a string then use the field as is.
             */
            if (is_numeric($slug) && is_string($field)) {
                $field = [
                    'field' => $field,
                ];
            }

            /*
             * If the slug is a string and the field
             * is a string too then use the field as the
             * type and the field as well.
             */
            if (!is_numeric($slug) && is_string($slug) && is_string($field)) {
                $field = [
                    'field' => $slug,
                    'type'  => $field,
                ];
            }

            /*
             * If the field is an array and does not
             * have the field parameter set then
             * use the slug.
             */
            if (is_array($field) && !isset($field['field'])) {
                $field['field'] = $slug;
            }

            /*
             * If the field is required then it must have
             * the rule as well.
             */
            if (array_get($field, 'required') === true) {
                $field['rules'] = array_unique(array_merge(array_get($field, 'rules', []), ['required']));
            }
        }

        return $fields;
    }

    /**
     * Normalize form sections.
     *
     * @param array $sections
     * @return array
     */
    public static function sections(array $sections)
    {
        foreach ($sections as $slug => &$section) {

            if (is_string($section)) {
                $section = [
                    'view' => $section,
                ];
            }

            /**
             * If tabs are defined but no orientation
             * then default to standard tabs.
             */
            if (isset($section['tabs']) && !isset($section['orientation'])) {
                $section['orientation'] = 'horizontal';
            }

            /*
             * Make sure some default parameters exist.
             */
            $section['attributes'] = array_get($section, 'attributes', []);

            /*
             * Move all data-* keys
             * to attributes.
             */
            foreach ($section as $attribute => $value) {
                if (str_is('data-*', $attribute)) {
                    array_set($section, 'attributes.' . $attribute, array_pull($section, $attribute));
                }
            }
        }

        return $sections;
    }

    /**
     * Normalize builder actions.
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
}
