<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\View\Command\TableQuery;
use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewQuery;

/**
 * Class TableQueryHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View\Command
 */
class TableQueryHandler
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
     * Handle the command.
     *
     * @param TableQuery $command
     */
    public function handle(TableQuery $command)
    {
        $table = $command->getTable();
        $query = $command->getQuery();

        $views = $table->getViews();

        if ($view = $views->active()) {
            $this->query->filter($table, $query, $view->getHandler());
        }
    }
}
