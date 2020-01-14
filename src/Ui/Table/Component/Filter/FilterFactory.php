<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

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
     * Make a filter.
     *
     * @param  array $parameters
     * @return FilterInterface
     */
    public function make(array $parameters)
    {
        $filter = app()->make(array_get($parameters, 'filter', $this->filter), $parameters);

        Hydrator::hydrate($filter, $parameters);

        return $filter;
    }
}
