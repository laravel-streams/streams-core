<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;

/**
 * Class FilterFactory
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FilterFactory
{

    /**
     * The default filter class.
     *
     * @var string
     */
    protected $filter = Filter::class;

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
     * @param  array           $parameters
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
