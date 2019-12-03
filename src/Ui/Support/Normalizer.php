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
     * Normalize buttons.
     *
     * @param array $buttons
     * @return array
     */
    public static function buttons(array $buttons)
    {
        foreach ($buttons as $key => &$button) {

            /*
             * If the button is a string but the key
             * is numeric then use the button as the
             * button type.
             */
            if (is_numeric($key) && is_string($button)) {
                $button = [
                    'button' => $button,
                ];
            }

            /*
             * If the button AND key are strings then
             * use the key as the button and the
             * button as the text parameters.
             */
            if (!is_numeric($key) && is_string($button)) {
                $button = [
                    'text'   => $button,
                    'button' => $key,
                ];
            }

            /*
             * If the key is not numeric and the button
             * is an array without the button key then
             * use the key as the button's type.
             */
            if (!is_numeric($key) && is_array($button) && !isset($button['button'])) {
                $button['button'] = $key;
            }
        }

        return $buttons;
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
             * Make sure attributes exists.
             */
            $item['attributes'] = array_get($item, 'attributes', []);

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
                // wtf.
                //$item['dropdown'] = self::start($item['dropdown'], $component, 'slug');
                //$item['dropdown'] = self::start($item['dropdown'], $component, 'slug');
            }
        }

        return $input;
    }
}
