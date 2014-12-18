<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Contract;

/**
 * Interface FilterRepositoryInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Filter\Contract
 */
interface FilterRepositoryInterface
{

    /**
     * Find a filter.
     *
     * @param  $filter
     * @return FilterInterface
     */
    public function find($filter);
}
