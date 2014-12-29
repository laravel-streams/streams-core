<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;

/**
 * Class FilterFactory
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Filter
 */
class FilterFactory
{

    /**
     * The default filter class.
     *
     * @var string
     */
    protected $filter = 'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Filter';

    /**
     * The filter registry.
     *
     * @var FilterRegistry
     */
    protected $filters;

    /**
     * The hydrator utility.
     *
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * Create a new FilterFactory instance.
     *
     * @param FilterRegistry $filters
     * @param Hydrator       $hydrator
     */
    public function __construct(FilterRegistry $filters, Hydrator $hydrator)
    {
        $this->filters  = $filters;
        $this->hydrator = $hydrator;
    }

    /**
     * Make a filter.
     *
     * @param  array $parameters
     * @return FilterInterface
     */
    public function make(array $parameters)
    {
        if ($filter = $this->filters->get(array_get($parameters, 'filter'))) {
            $parameters = array_replace_recursive($filter, array_except($parameters, 'filter'));
        }

        $filter = app()->make(array_get($parameters, 'filter', $this->filter), $parameters);

        $this->hydrator->hydrate($filter, $parameters);

        return $filter;
    }
}
