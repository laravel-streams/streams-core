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
     * Normalize navigation.
     *
     * @param array $navigation
     * @return array
     */
    public static function navigation(array $navigation)
    {
        foreach ($navigation as $path => &$link) {

            /*
             * If the link is a string
             * then it must be in the
             * $path => $title format.
             */
            if (is_string($link)) {
                $link = [
                    'href' => $path,
                ];
            }
        }

        return $navigation;
    }

    /**
     * Normalize sections.
     *
     * @param array $sections
     * @return array
     */
    public static function sections(array $sections)
    {

        /*
         * Move child sections into main array.
         */
        foreach ($sections as $slug => &$section) {
            if (isset($section['sections'])) {
                foreach ($section['sections'] as $key => $child) {

                    /**
                     * It's a slug only!
                     */
                    if (is_string($child)) {
                        $key = $child;

                        $child = ['slug' => $child];
                    }

                    $child['parent'] = array_get($section, 'slug', $slug);
                    $child['slug']   = array_get($child, 'slug', $key);

                    $sections[$key] = $child;
                }
            }
        }

        /*
         * Loop over each section and make sense of the input
         * provided for the given module.
         */
        foreach ($sections as $slug => &$section) {

            /*
             * If the slug is not valid and the section
             * is a string then use the section as the slug.
             */
            if (is_numeric($slug) && is_string($section)) {
                $section = [
                    'slug' => $section,
                ];
            }

            /*
             * If the slug is a string and the title is not
             * set then use the slug as the slug.
             */
            if (is_string($slug) && !isset($section['slug'])) {
                $section['slug'] = $slug;
            }

            /**
             * Make sure attributes exists.
             */
            $item['attributes'] = array_get($section, 'attributes', []);

            /*
             * Move the data-href into the permalink.
             *
             * @deprecated as of v3.2
             */
            if (!isset($section['permalink']) && isset($section['attributes']['data-href'])) {
                $section['permalink'] = array_pull($section, 'attributes.data-href');
            }

            if (
                isset($section['permalink']) &&
                is_string($section['permalink']) &&
                !starts_with($section['permalink'], 'http')
            ) {
                $section['permalink'] = url($section['permalink']);
            }
        }

        return $sections;
    }

    /**
     * Normalize shortcuts.
     *
     * @param array $shortcuts
     */
    public static function shortcuts(array $shortcuts)
    {
        /*
         * Move child shortcuts into main array.
         */
        foreach ($shortcuts as $slug => &$shortcut) {
            if (isset($shortcut['shortcuts'])) {
                foreach ($shortcut['shortcuts'] as $key => $child) {

                    /**
                     * It's a slug only!
                     */
                    if (is_string($child)) {
                        $key = $child;

                        $child = ['slug' => $child];
                    }

                    $child['parent'] = array_get($shortcut, 'slug', $slug);
                    $child['slug']   = array_get($child, 'slug', $key);

                    $shortcuts[$key] = $child;
                }
            }
        }

        /*
         * Loop over each shortcut and make sense of the input
         * provided for the given module.
         */
        foreach ($shortcuts as $slug => &$shortcut) {

            /*
             * If the slug is not valid and the shortcut
             * is a string then use the shortcut as the slug.
             */
            if (is_numeric($slug) && is_string($shortcut)) {
                $shortcut = [
                    'slug' => $shortcut,
                ];
            }

            /*
             * If the slug is a string and the title is not
             * set then use the slug as the slug.
             */
            if (is_string($slug) && !isset($shortcut['slug'])) {
                $shortcut['slug'] = $slug;
            }
        }

        return $shortcuts;
    }

    /**
     * Normalize builder actions.
     *
     * @param array $actions
     * @param string $prefix
     */
    public static function actions(array $actions, $prefix)
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
     * Start normalization for a component.
     *
     * @param array $input
     * @param string $default
     * @param string $secondary
     * @return array
     */
    public static function start(array $input, $default, $secondary = null, $eager = false)
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
            if ($secondary && $eager && is_numeric($key) && is_string($item)) {
                $item = [
                    $default   => $item,
                    $secondary => $item,
                ];
            }

            /**
             * If the key is NOT numeric and the item is a
             * string then use the key as the secondary and the
             * item as the default.
             */
            if ($secondary && !is_numeric($key) && is_string($item)) {
                $item = [
                    $default   => $item,
                    $secondary => $key,
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
    public static function ensure(array $input, $promise)
    {
        foreach ($input as $key => &$item) {

            /**
             * If the key is not numeric and the item is an
             * array without a promise then use the key for
             * the defualt by promise.
             */
            if (is_array($item) && !isset($item[$promise]) && !is_numeric($key)) {
                $item[$promise] = $key;
            }
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
