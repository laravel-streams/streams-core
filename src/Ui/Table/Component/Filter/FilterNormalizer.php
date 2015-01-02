<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

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
     * @param array           $filters
     * @param StreamInterface $stream
     * @return array
     */
    public function normalize(array $filters, StreamInterface $stream = null)
    {
        foreach ($filters as $slug => &$filter) {

            /**
             * If the filter is a string then use
             * it for everything.
             */
            if (is_string($filter)) {
                $filter = [
                    'slug'   => $filter,
                    'field'  => $filter,
                    'filter' => 'field',
                ];
            }

            /**
             * Move the slug to the filter.
             */
            if (!isset($filter['slug'])) {
                $filter['slug'] = $slug;
            }

            /**
             * Set the table's stream.
             */
            $filter['stream'] = $stream;
        }

        return $filters;
    }
}
