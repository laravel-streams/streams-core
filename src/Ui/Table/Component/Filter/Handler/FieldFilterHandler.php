<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FieldFilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FieldFilterHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter\Handler
 */
class FieldFilterHandler
{

    /**
     * Handle the filter.
     *
     * @param Builder         $query
     * @param FilterInterface $filter
     */
    public function handle(Builder $query, FieldFilterInterface $filter)
    {
        $stream = $filter->getStream();

        $fieldType = $stream->getFieldType($filter->getField());

        $fieldTypeQuery = $fieldType->getQuery();

        $fieldTypeQuery->filter($query, $filter->getValue());
    }
}
