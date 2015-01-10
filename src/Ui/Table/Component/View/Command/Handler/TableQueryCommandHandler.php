<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\View\Command\TableQueryCommand;
use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewQuery;

/**
 * Class TableQueryCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View\Command
 */
class TableQueryCommandHandler
{

    /**
     * The view query.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewQuery
     */
    protected $query;

    /**
     * Create a new TableQueryCommandHandler instance.
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
     * @param TableQueryCommand $command
     */
    public function handle(TableQueryCommand $command)
    {
        $table = $command->getTable();
        $query = $command->getQuery();

        $views = $table->getViews();

        if ($view = $views->active()) {
            $this->query->filter($table, $query, $view->getHandler());
        }
    }
}
