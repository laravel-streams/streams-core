<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Guesser;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class PlaceholdersGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter\Guesser
 */
class PlaceholdersGuesser
{

    /**
     * Guess some table table filter placeholders.
     *
     * @param TableBuilder $builder
     */
    public function guess(TableBuilder $builder)
    {
        $filters = $builder->getFilters();
        $stream  = $builder->getTableStream();

        foreach ($filters as &$filter) {

            // Only guessing for filter types.
            if ($filter['filter'] !== 'field') {
                continue;
            }

            // Skip if we already have a placeholder.
            if (isset($filter['placeholder'])) {
                continue;
            }

            // Get the placeholder off the assignment.
            if ($assignment = $stream->getAssignment($filter['field'])) {

                /**
                 * Always use the field name
                 * as the placeholder. Placeholders
                 * that are assigned otherwise usually
                 * feel out of context:
                 *
                 * "Choose an option..." in the filter
                 * would just be weird.
                 */
                $filter['placeholder'] = $assignment->getFieldName();
            }
        }

        $builder->setFilters($filters);
    }
}
