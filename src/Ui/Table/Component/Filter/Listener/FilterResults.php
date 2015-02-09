<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Listener;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterQueryer;
use Anomaly\Streams\Platform\Ui\Table\Event\QueryHasStarted;

/**
 * Class FilterResults
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Listener
 */
class FilterResults
{

    /**
     * The filter query utility.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterQueryer
     */
    protected $query;

    /**
     * Create a new FilterQueryHandler instance.
     *
     * @param FilterQueryer $query
     */
    public function __construct(FilterQueryer $query)
    {
        $this->query = $query;
    }

    /**
     * Handle the event.
     *
     * @param QueryHasStarted $event
     * @throws \Exception
     */
    public function handle(QueryHasStarted $event)
    {
        $table = $event->getTable();
        $query = $event->getQuery();

        $filters = $table->getFilters();

        foreach ($filters->active() as $filter) {
            if ($filter instanceof FilterInterface) {
                $this->query->filter($table, $query, $filter);
            }
        }
    }
}
