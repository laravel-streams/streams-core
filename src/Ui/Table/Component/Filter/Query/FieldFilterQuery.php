<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Query;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FieldFilterInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FieldFilterQuery
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter\Handler
 */
class FieldFilterQuery implements SelfHandling
{

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new FieldFilterQuery instance.
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
     * @param Builder              $query
     * @param FieldFilterInterface $filter
     * @param TableBuilder         $builder
     */
    public function handle(Builder $query, FieldFilterInterface $filter, TableBuilder $builder)
    {
        $stream = $filter->getStream();

        $fieldType = $stream->getFieldType($filter->getField());

        $fieldTypeQuery = $fieldType->getQuery();

        $this->container->call([$fieldTypeQuery, 'filter'], compact('query', 'filter', 'builder'));
    }
}
