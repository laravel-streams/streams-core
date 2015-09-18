<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FilterQuery.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter
 */
class FilterQuery
{
    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new FilterQuery instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Modify the table's query using the filters.
     *
     * @param TableBuilder    $builder
     * @param FilterInterface $filter
     * @param Builder         $query
     */
    public function filter(TableBuilder $builder, FilterInterface $filter, Builder $query)
    {
        /*
         * If the filter is self handling then let
         * it filter the query itself.
         */
        if ($filter instanceof SelfHandling) {
            $this->container->call([$filter, 'handle'], compact('builder', 'query', 'filter'));

            return;
        }

        $handler = $filter->getQuery();

        // Self handling implies @handle
        if (is_string($handler) && ! str_contains($handler, '@') && class_implements($handler, SelfHandling::class)) {
            $handler .= '@handle';
        }

        /*
         * If the handler is a callable string or Closure
         * then call it using the IoC container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            $this->container->call($handler, compact('builder', 'query', 'filter'));
        }
    }
}
