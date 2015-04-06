<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Listener;

use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewQuery;
use Anomaly\Streams\Platform\Ui\Table\Event\TableIsQuerying;

/**
 * Class ApplyView
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Listener
 */
class ApplyView
{

    /**
     * The view query.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewQuery
     */
    protected $query;

    /**
     * Create a new TableQueryHandler instance.
     *
     * @param ViewQuery $query
     */
    public function __construct(ViewQuery $query)
    {
        $this->query = $query;
    }

    /**
     * Handle the event.
     *
     * @param TableIsQuerying $event
     */
    public function handle(TableIsQuerying $event)
    {
        $query   = $event->getQuery();
        $builder = $event->getBuilder();
        $table   = $builder->getTable();

        $views = $table->getViews();

        if ($view = $views->active()) {
            $this->query->filter($table, $query, $view->getHandler());
        }
    }
}
