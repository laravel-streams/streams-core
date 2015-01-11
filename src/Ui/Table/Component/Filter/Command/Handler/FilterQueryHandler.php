<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\FilterQuery;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterQueryer;

/**
 * Class FilterQueryHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command
 */
class FilterQueryHandler
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
     * Handle the command.
     *
     * @param FilterQuery $command
     */
    public function handle(FilterQuery $command)
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
