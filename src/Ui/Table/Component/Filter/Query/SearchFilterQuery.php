<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Query;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\SearchFilterInterface;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class SearchFilterQuery
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter\Handler
 */
class SearchFilterQuery implements SelfHandling
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
     * @param Builder               $query
     * @param SearchFilterInterface $filter
     */
    public function handle(Builder $query, SearchFilterInterface $filter)
    {
        $stream = $filter->getStream();

        if ($stream->isTranslatable()) {
            $query->leftJoin(
                $stream->getEntryTranslationsTableName(),
                $stream->getEntryTableName() . '.id',
                '=',
                $stream->getEntryTranslationsTableName() . '.entry_id'
            );
        }

        $query->where(
            function (Builder $query) use ($filter, $stream) {

                foreach ($filter->getColumns() as $column) {
                    $query->orWhere($column, 'LIKE', "%{$filter->getValue()}%");
                }

                foreach ($filter->getFields() as $field) {

                    $filter->setField($field);

                    $fieldType      = $stream->getFieldType($field);
                    $fieldTypeQuery = $fieldType->getQuery();

                    $fieldTypeQuery->setConstraint('or');

                    $this->container->call([$fieldTypeQuery, 'filter'], compact('query', 'filter', 'builder'));
                }
            }
        );
    }
}
