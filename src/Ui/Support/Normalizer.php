<?php

namespace Anomaly\Streams\Platform\Ui\Support;

/**
 * Class Normalizer
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Normalizer
{

    /**
     * Start normalization for a component.
     *
     * @param array $input
     * @param string $default
     * @param string $secondary
     * @return array
     */
    public static function start(array $input, $default, $secondary = null)
    {
        foreach ($input as $key => &$item) {

            /*
             * Skip placeholders.
             */
            if ($item == '*') {
                continue;
            }

            /**
             * If the key is numeric and the item is
             * a string then treat the item as both the
             * default and the secondary.
             */
            if ($secondary && is_numeric($key) && is_string($item)) {
                $item = [
                    $secondary => $item,
                    $default   => $item,
                ];
            }

            /**
             * If the key is NOT numeric and the item is a
             * string then use the key as the secondary and the
             * item as the default.
             */
            if ($secondary && !is_numeric($key) && is_string($item)) {
                $item = [
                    $secondary => $key,
                    $default   => $item,
                ];
            }

            /*
             * If the key is a string and the component
             * is a string too then use the component as the
             * secondary and the default as well.
             */
            if ($secondary && !is_numeric($key) && is_string($key) && is_string($item)) {
                $item = [
                    $default => $key,
                    $secondary  => $item,
                ];
            }

            /**
             * If the key is not numeric and the item is an
             * array without a secondary then use the key for
             * the secondary by default.
             */
            if ($secondary && is_array($item) && !isset($item[$secondary]) && !is_numeric($key)) {
                $item[$secondary] = $key;
            }

            /**
             * If the key is not numeric and the item is an
             * array without a default then use the key for
             * the defualt by default.
             */
            if (is_array($item) && !isset($item[$default]) && !is_numeric($key)) {
                $item[$default] = $key;
            }

            /**
             * If the item is a string then use
             * it as the default parameter.
             * 
             * This is essentially for
             * registered components.
             */
            if (is_string($item)) {
                $item = [
                    $default => $item,
                ];
            }

            /**
             * If the key is a string and the component
             * is an array without a component parameter then
             * move the key into the component as that parameter.
             */
            if (!is_integer($key) && !isset($item[$default])) {
                $item[$default] = $key;
            }
        }

        return $input;
    }

    /**
     * Normalize for a slug.
     *
     * @param array $input
     * @param string $slug
     * @return array
     */
    public static function slug(array $input, $slug)
    {
        foreach ($input as $key => &$item) {
            //
        }

        return $input;
    }


    /**
     * Normalize HTML attributes.
     *
     * @param array $input
     * @param array $default
     * @return array
     */
    public static function attributes(array $input, array $default = [])
    {
        foreach ($input as $key => &$item) {

            /**
             * Make sure default parameters exist.
             */
            if ($attributes = array_merge($default, array_get($item, 'attributes', []))) {
                $item['attributes'] = $attributes;
            }

            /**
             * Move the HREF if any to attributes.
             */
            if (isset($item['href'])) {
                array_set($item['attributes'], 'href', array_pull($item, 'href'));
            }

            /**
             * Move the URL if any to attributes.
             */
            if (isset($item['url'])) {
                array_set($item['attributes'], 'url', array_pull($item, 'url'));
            }

            /**
             * Move the target if any to attributes.
             */
            if (isset($item['target'])) {
                array_set($item['attributes'], 'target', array_pull($item, 'target'));
            }

            /**
             * Move all data-* keys to attributes.
             */
            foreach ($item as $attribute => $value) {
                if (str_is('data-*', $attribute)) {
                    array_set($item, 'attributes.' . $attribute, array_pull($item, $attribute));
                }
            }


            /**
             * Make sure the HREF is absolute.
             */
            if (
                isset($item['attributes']['href']) &&
                is_string($item['attributes']['href']) &&
                !starts_with($item['attributes']['href'], ['http', '{', '//'])
            ) {
                $item['attributes']['href'] = url($item['attributes']['href']);
            }
        }

        return $input;
    }

    /**
     * Normalize dropdons.
     *
     * @param array $input
     * @param array $default
     */
    public static function dropdowns(array $input, string $component = 'item')
    {

        foreach ($input as $key => &$item) {
            if (isset($item['dropdown'])) {
                $item['dropdown'] = self::start($item['dropdown'], $component, 'slug');
                $item['dropdown'] = self::start($item['dropdown'], $component, 'slug');
            }
        }

        return $input;
    }

    /**
     * Normalize fields.
     *
     * @param array $input
     */
    public static function fields(array $input)
    {

        $input = self::start($input, 'field');

        foreach ($input as $key => &$item) {

            /*
             * If the field is a wild card marker
             * then just continue.
             */
            if ($item == '*') {
                continue;
            }

            /*
             * If the field is an array and does not
             * have the field parameter set then
             * use the slug.
             */
            if (is_array($item) && !isset($item['field'])) {
                $item['field'] = $key;
            }

            /*
             * If the field is required then it must have
             * the rule as well.
             */
            if (array_get($item, 'required') === true) {
                $item['rules'] = array_unique(array_merge(array_get($item, 'rules', []), ['required']));
            }
        }

        return $input;
    }
}
