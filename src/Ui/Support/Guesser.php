<?php

namespace Anomaly\Streams\Platform\Ui\Support;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class Guesser
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Guesser
{

    /**
     * Guess button properties.
     *
     * @param $builder
     * @param StreamInterface $stream
     */
    public static function buttons($builder, StreamInterface $stream = null)
    {
        $buttons = $builder->getButtons();

        if (!$section = app('cp.sections')->active()) {
            return;
        }

        if (!$module = app('module.collection')->active()) {
            return;
        }

        foreach ($buttons as &$button) {

            // If we already have an HREF then skip it.
            if (isset($button['attributes']['href'])) {
                continue;
            }

            /**
             * If a route has been defined then
             * move that to an HREF closure.
             */
            if (isset($button['route']) && $builder->getTableStream()) {
                $button['attributes']['href'] = function ($entry) use ($button) {

                    /* @var EntryInterface $entry */
                    return $entry->route($button['route']);
                };

                continue;
            }

            switch (array_get($button, 'button')) {

                case 'restore':

                    $button['attributes']['href'] = $this->url->to(
                        'entry/handle/restore/' . $module->getNamespace() . '/' . $stream->getNamespace() . '/' . $stream->getSlug() . '/{entry.id}'
                    );

                    break;

                default:

                    // Determine the HREF based on the button type.
                    $type = array_get($button, 'segment', array_get($button, 'button'));

                    if ($type && !str_contains($type, '\\') && !class_exists($type)) {
                        $button['attributes']['href'] = $section->getHref($type . '/{entry.id}');
                    }

                    break;
            }
        }

        $builder->setButtons($buttons);
    }

    /**
     * Guess action properties.
     *
     * @param $builder
     */
    public static function actions($builder)
    {
        $actions = $builder->getActions();

        /* @var \Anomaly\Streams\Platform\Addon\Module\Module $module */
        $module = app('module.collection')->active();

        $class = explode('\\', get_class($builder));

        array_pop($class);

        /**
         * Guess Text
         */
        if ($module) {
            foreach ($actions as &$action) {

                // Only if it's not already set.
                if (!isset($action['text'])) {
                    $action['text'] = $module->getNamespace('button.' . $action['slug']);
                }
            }
        }

        /**
         * Guess Handler
         */
        foreach ($actions as &$action) {

            // Only if it's not already set.
            if (!isset($action['handler'])) {

                $handler = implode('\\', $class) . '\\Action\\' . ucfirst(camel_case($action['slug'])) . 'Handler';

                if (class_exists($handler)) {
                    $action['handler'] = $handler . '@handle';
                }
            }
        }

        $builder->setActions($actions);
    }
}
