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
     * Start normalization for a compoent.
     *
     * @param array $input
     * @param [type] $component
     */
    public static function component(array &$input, $component)
    {
        foreach ($input as $key => $item) {

            /**
             * If the item is a string then use
             * it as the comopnent parameter.
             * 
             * This is essentially for
             * registered components.
             */
            if (is_string($item)) {
                $item = [
                    $component => $item,
                ];
            }

            /**
             * If the key is a string and the component
             * is an array without a component parameter then
             * move the key into the component as that parameter.
             */
            if (!is_integer($key) && !isset($item[$component])) {
                $item[$component] = $key;
            }
        }
    }


    /**
     * Normalize HTML attributes.
     *
     * @param array $input
     * @param array $default
     */
    public static function attributes(array &$input, array $default = [])
    {
        foreach ($input as $key => $item) {

            /**
             * Make sure default parameters exist.
             */
            $item['attributes'] = array_merge($default, array_get($item, 'attributes', []));

            /**
             * Move the HREF if any to attributes.
             */
            if (isset($item['href'])) {
                array_set($item['attributes'], 'href', array_pull($item, 'href'));
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
    }
}
