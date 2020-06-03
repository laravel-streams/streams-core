<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Workflows\Filters;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type\FieldFilter;

/**
 * Class NormalizeFilters
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NormalizeFilters
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $filters = $builder->filters;

        if ($builder->instance->options->get('sortable')) {
            $filters = array_merge(['reorder'], $filters);
        }

        foreach ($filters as $slug => &$filter) {

            /*
             * If the slug is numeric and the filter is
             * a string then treat the string as both the
             * filter and the slug. This is OK as long as
             * there are not multiple instances of this
             * input using the same filter which is not likely.
             */
            if (is_numeric($slug) && is_string($filter)) {
                $filter = [
                    'slug' => $filter,
                    'filter' => FieldFilter::class,
                ];
            }

            /*
             * If the slug is NOT numeric and the filter is a
             * string then use the slug as the slug and the
             * filter as the filter.
             */
            if (!is_numeric($slug) && is_string($filter)) {
                $filter = [
                    'slug' => $slug,
                    'filter' => $filter,
                ];
            }

            /*
             * If the slug is not numeric and the filter is an
             * array without a slug then use the slug for
             * the slug for the filter.
             */
            if (is_array($filter) && !isset($filter['slug']) && !is_numeric($slug)) {
                $filter['slug'] = $slug;
            }

            /*
             * Make sure we have a filter property.
             */
            if (is_array($filter) && !isset($filter['filter'])) {
                $filter['filter'] = $filter['slug'];
            }
        }

        $filters = Normalizer::attributes($filters);

        /**
         * Go back over and assume HREFs.
         * @todo refilter this - from guesser
         */
        foreach ($filters as $slug => &$filter) {
            //
        }

        $builder->filters = $filters;
    }
}
