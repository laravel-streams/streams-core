<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\FilterQueryCommand;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterQuery;

/**
 * Class FilterQueryCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command
 */
class FilterQueryCommandHandler
{

    /**
     * The filter query utility.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterQuery
     */
    protected $query;

    /**
     * Create a new FilterQueryCommandHandler instance.
     *
     * @param FilterQuery $query
     */
    public function __construct(FilterQuery $query)
    {
        $this->query = $query;
    }

    /**
     * Handle the command.
     *
     * @param FilterQueryCommand $command
     */
    public function handle(FilterQueryCommand $command)
    {
        $table = $command->getTable();
        $query = $command->getQuery();

        $filters = $table->getFilters();

        foreach ($filters->active() as $filter) {
            if ($filter instanceof FilterInterface) {
                $this->query->filter($table, $query, $filter);
            }
        }
    }
}
