<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Query;

use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Builder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\View\Contract\ViewQueryInterface;

/**
 * Class ViewAllQueryQuery
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class RecentlyCreatedQuery implements ViewQueryInterface
{

    /**
     * Handle the query.
     *
     * @param TableBuilder $builder
     * @param Builder      $query
     */
    public function handle(TableBuilder $builder, Builder $query)
    {
        if (Request::get('order_by') !== 'created_at') {
            $query->orderBy('created_at', 'desc');
        }
    }
}
