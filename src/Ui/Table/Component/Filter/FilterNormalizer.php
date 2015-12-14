<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class FilterNormalizer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter
 */
class FilterNormalizer
{

    /**
     * Normalize filter input.
     *
     * @param TableBuilder $builder
     */
    public function normalize(TableBuilder $builder)
    {
        $filters = $builder->getFilters();
        $stream  = $builder->getTableStream();

        foreach ($filters as $slug => &$filter) {

            /**
             * If the filter is a string then use
             * it for everything.
             */
            if (is_string($filter) && !str_contains($filter, '/')) {
                $filter = [
                    'slug'   => $filter,
                    'field'  => $filter,
                    'filter' => 'field'
                ];
            }

            /**
             * If the filter is a class string then use
             * it for the filter.
             */
            if (is_string($filter) && str_contains($filter, '/')) {
                $filter = [
                    'slug'   => $slug,
                    'filter' => $filter
                ];
            }

            /**
             * Move the slug to the filter.
             */
            if (!isset($filter['slug'])) {
                $filter['slug'] = $slug;
            }

            /**
             * Fallback the field.
             */
            if (!isset($filter['field']) && $stream && $stream->hasAssignment($filter['slug'])) {
                $filter['field'] = $filter['slug'];
            }

            /**
             * Set the table's stream.
             */
            if ($stream) {
                $filter['stream'] = $stream;
            }
        }

        $builder->setFilters($filters);
    }
}
