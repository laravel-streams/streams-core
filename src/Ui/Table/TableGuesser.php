<?php

namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Support\Guesser;

/**
 * Class TableGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TableGuesser extends Guesser
{

    /**
     * Guess table view properties.
     *
     * @param TableBuilder $builder
     */
    public static function views(TableBuilder $builder)
    {
        $views = $builder->getViews();

        /* @var \Anomaly\Streams\Platform\Addon\Module\Module $module */
        $module = app('module.collection')->active();

        /**
         * Guess HREF
         */
        foreach ($views as &$view) {

            // Only automate it if not set.
            if (!isset($view['attributes']['href'])) {
                $view['attributes']['href'] = url(
                    request()->path() . '?' . array_get($view, 'prefix') . 'view=' . $view['slug']
                );
            }
        }

        /**
         * Guess Text
         */
        if ($module) {
            foreach ($views as &$view) {

                // Only automate it if not set.
                if (!isset($view['text'])) {
                    $view['text'] = $module->getNamespace('view.' . $view['slug']);
                }
            }
        }

        /**
         * Guess Query
         */
        foreach ($views as &$view) {

            // Only automate it if not set.
            if (!isset($view['query'])) {

                $class = explode('\\', get_class($builder));

                array_pop($class);

                $class = implode('\\', $class) . '\\View\\' . ucfirst(camel_case($view['slug'])) . 'Query';

                if (class_exists($class)) {
                    $view['query'] = $class . '@handle';
                }
            }
        }

        /**
         * Guess Handler
         */
        foreach ($views as &$view) {

            // Only automate it if not set.
            if (!isset($view['handler'])) {

                $class = explode('\\', get_class($builder));

                array_pop($class);

                $class = implode('\\', $class) . '\\View\\' . ucfirst(camel_case($view['slug'])) . 'Handler';

                if (class_exists($class)) {
                    $view['handler'] = $class . '@handle';
                }
            }
        }

        $builder->setViews($views);
    }

    /**
     * Guess table filter properties.
     *
     * @param TableBuilder $builder
     */
    public static function filters(TableBuilder $builder)
    {
        $filters = $builder->getFilters();
        $stream  = $builder->getTableStream();

        $module = app('module.collection')->active();

        foreach ($filters as &$filter) {

            // Skip if we already have a placeholder.
            if (isset($filter['placeholder'])) {
                continue;
            }

            // Get the placeholder off the assignment.
            if ($stream && $assignment = $stream->getAssignment(array_get($filter, 'field'))) {

                /*
                 * Always use the field name
                 * as the placeholder. Placeholders
                 * that are assigned otherwise usually
                 * feel out of context:
                 *
                 * "Choose an option..." in the filter
                 * would just be weird.
                 */
                $placeholder = $assignment->getFieldName();

                if (trans()->has($placeholder)) {
                    $filter['placeholder'] = $placeholder;
                }
            }

            if (!$module) {
                continue;
            }

            $placeholder = $module->getNamespace('field.' . $filter['slug'] . '.placeholder');

            if (!isset($filter['placeholder']) && trans()->has($placeholder)) {
                $filter['placeholder'] = $placeholder;
            }

            $placeholder = $module->getNamespace('field.' . $filter['slug'] . '.name');

            if (!isset($filter['placeholder']) && trans()->has($placeholder)) {
                $filter['placeholder'] = $placeholder;
            }

            if (!array_get($filter, 'placeholder')) {
                $filter['placeholder'] = $filter['slug'];
            }

            if (
                !trans()->has($filter['placeholder'])
                && config('streams::system.lazy_translations')
            ) {
                $filter['placeholder'] = ucwords(humanize($filter['placeholder']));
            }
        }

        $builder->setFilters($filters);
    }
}
