<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Type;

use Anomaly\Streams\Platform\Ui\Table\Component\View\Query\RecentlyCreatedQuery;
use Anomaly\Streams\Platform\Ui\Table\Component\View\View;

/**
 * Class RecentlyCreated
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class RecentlyCreated extends View
{

    /**
     * The view query.
     *
     * @var string
     */
    protected $query = RecentlyCreatedQuery::class;
}
