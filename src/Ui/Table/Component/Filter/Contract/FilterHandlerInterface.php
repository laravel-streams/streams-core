<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract;

use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Interface FilterHandlerInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract
 */
interface FilterHandlerInterface
{

    /**
     * Handle the filter.
     *
     * @param Table           $table
     * @param Builder         $query
     * @param FilterInterface $filter
     * @return mixed
     */
    public function handle(Table $table, Builder $query, FilterInterface $filter);
}
