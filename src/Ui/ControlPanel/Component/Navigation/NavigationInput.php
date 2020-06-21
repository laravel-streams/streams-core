<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Translation\Translator;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Event\SortNavigation;

/**
 * Class NavigationInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NavigationInput
{

    /**
     * Read the navigation input.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function read(ControlPanelBuilder $builder)
    {
        self::resolve($builder);
        self::normalize($builder);
        self::sort($builder);
        self::translate($builder);
    }

    /**
     * Resolve input.
     *
     * @param \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder $builder
     */
    protected static function resolve(ControlPanelBuilder $builder)
    {
        $navigation = resolver($builder->getNavigation(), compact('builder'));

        $builder->setNavigation(evaluate($navigation ?: $builder->getNavigation(), compact('builder')));
    }

    /**
     * Normalize input.
     *
     * @param \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder $builder
     */
    protected static function normalize(ControlPanelBuilder $builder)
    {
        $links = $builder->getNavigation();

        foreach ($links as $path => &$link) {

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

            /*
             * Make sure we have attributes.
             */
            $link['attributes'] = Arr::get($link, 'attributes', []);

            /*
             * Move the HREF into attributes.
             */
            if (isset($link['href'])) {
                $link['attributes']['href'] = Arr::pull($link, 'href');
            }

            /*
             * Move all data-* keys
             * to attributes.
             */
            foreach ($link as $attribute => $value) {
                if (Str::is('data-*', $attribute)) {
                    Arr::set($link, 'attributes.' . $attribute, Arr::pull($link, $attribute));
                }
            }

            /*
             * Make sure the HREF is absolute.
             */
            if (
                isset($link['attributes']['href']) &&
                is_string($link['attributes']['href']) &&
                !Str::startsWith($link['attributes']['href'], 'http')
            ) {
                $link['attributes']['href'] = url($link['attributes']['href']);
            }
        }

        $builder->setNavigation($links);
    }

    /**
     * Sort input.
     *
     * @param \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder $builder
     */
    protected static function sort(ControlPanelBuilder $builder)
    {
        if (!$navigation = $builder->getNavigation()) {
            return;
        }

        ksort($navigation);

        /**
         * Make the namespaces the key now
         * that we've applied default sorting.
         */
        $navigation = array_combine(
            array_map(
                function ($item) {
                    return $item['slug'];
                },
                $navigation
            ),
            array_values($navigation)
        );

        /**
         * Again by default push the dashboard
         * module to the top of the navigation.
         */
        foreach ($navigation as $key => $module) {
            if ($key == 'anomaly.module.dashboard') {
                $navigation = [$key => $module] + $navigation;

                break;
            }
        }

        $builder->setNavigation($navigation);

        event(new SortNavigation($builder));
    }

    /**
     * Translate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder $builder
     */
    protected static function translate(ControlPanelBuilder $builder)
    {
        $builder->setNavigation(Translator::translate($builder->getNavigation()));
    }
}
