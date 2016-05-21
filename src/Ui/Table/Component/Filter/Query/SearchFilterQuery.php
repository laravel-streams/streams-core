<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Query;

use Anomaly\Streams\Platform\Model\EloquentQueryBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\SearchFilterInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
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
    public function handle(Builder $query, TableBuilder $builder, SearchFilterInterface $filter)
    {
        $stream = $filter->getStream();
        $model  = $builder->getTableModel();

        /**
         * If a stream is available then join it's
         * translation table for filtering.
         *
         * @var EloquentQueryBuilder $query
         */
        if ($stream && $stream->isTranslatable() && !$query->hasJoin($stream->getEntryTranslationsTableName())) {
            $query->leftJoin(
                $stream->getEntryTranslationsTableName(),
                $stream->getEntryTableName() . '.id',
                '=',
                $stream->getEntryTranslationsTableName() . '.entry_id'
            );
        }

        /**
         * If a stream is NOT available then join the
         * model translation table for filtering.
         *
         * @var EloquentQueryBuilder $query
         */
        if (!$stream && $model->getTranslationModelName() && !$query->hasJoin($model->getTranslationTableName())) {
            $query->leftJoin(
                $model->getTranslationTableName(),
                $model->getTableName() . '.id',
                '=',
                $model->getTranslationTableName() . '.stream_id'
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
