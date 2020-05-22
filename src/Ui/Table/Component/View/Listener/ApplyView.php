<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Listener;

use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewQuery;
use Anomaly\Streams\Platform\Ui\Table\Event\TableIsQuerying;

/**
 * Class ApplyView
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ApplyView
{

    /**
     * The view query.
     *
     * @var ViewQuery
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
        $builder = $event->getBuilder();

        if ($view = $builder->table->views->active()) {
            $this->query->handle($event->getBuilder(), $event->getCriteria(), $view);
        }
        dd('View');
    }
}
