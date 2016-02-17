<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Query;

use Anomaly\Streams\Platform\Entry\EntryQueryBuilder;
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
     * Handle the filter.
     *
     * @param Builder               $query
     * @param SearchFilterInterface $filter
     */
    public function handle(Builder $query, SearchFilterInterface $filter)
    {
        $stream = $filter->getStream();

        if ($stream && $stream->isTranslatable() && $query instanceof EntryQueryBuilder) {
            $query->joinTranslations();
        }

        $query->where(
            function (Builder $query) use ($filter) {
                foreach ($filter->getColumns() as $column) {
                    $query->orWhere($column, 'LIKE', "%{$filter->getValue()}%");
                }
            }
        );
    }
}
