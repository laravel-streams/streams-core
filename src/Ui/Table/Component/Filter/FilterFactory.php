<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

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
     * Create a new FilterFactory instance.
     *
     * @param FilterRegistry $filters
     */
    public function __construct(FilterRegistry $filters)
    {
        $this->filters = $filters;
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

        $this->hydrate($filter, $parameters);

        return $filter;
    }

    /**
     * Hydrate the filter with it's remaining parameters.
     *
     * @param FilterInterface $filter
     * @param array           $parameters
     */
    protected function hydrate(FilterInterface $filter, array $parameters)
    {
        foreach ($parameters as $parameter => $value) {

            $method = camel_case('set_' . $parameter);

            if (method_exists($filter, $method)) {
                $filter->{$method}($value);
            }
        }
    }
}
