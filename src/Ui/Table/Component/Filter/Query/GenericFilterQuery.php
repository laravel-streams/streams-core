<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Query;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class GenericFilterQuery
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GenericFilterQuery
{

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new GenericFilterQuery instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Handle the filter.
     *
     * @param Builder         $query
     * @param FilterInterface $filter
     */
    public function handle(Builder $query, FilterInterface $filter)
    {
        $stream = $filter->getStream();

        if ($stream && $fieldType = $stream->getFieldType($filter->getField())) {
            $fieldTypeQuery = $fieldType->getQuery();

            $this->container->call([$fieldTypeQuery, 'filter'], compact('query', 'filter', 'builder'));

            return;
        }

        if ($stream && $fieldType = $stream->getFieldType($filter->getSlug())) {
            $fieldTypeQuery = $fieldType->getQuery();

            $this->container->call([$fieldTypeQuery, 'filter'], compact('query', 'filter', 'builder'));

            return;
        }

        if ($filter->isExact()) {
            $query->where($filter->getSlug(), $filter->getValue());
        } else {
            $query->where($filter->getSlug(), 'LIKE', "%{$filter->getValue()}%");
        }
    }
}
