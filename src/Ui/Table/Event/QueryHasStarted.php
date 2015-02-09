<?php namespace Anomaly\Streams\Platform\Ui\Table\Event;

use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class QueryHasStarted
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Event
 */
class QueryHasStarted
{

    /**
     * The table object.
     *
     * @var Table
     */
    protected $table;

    /**
     * The table query.
     *
     * @var Builder
     */
    protected $query;

    /**
     * Create a new QueryHasStarted instance.
     *
     * @param Table   $table
     * @param Builder $query
     */
    public function __construct(Table $table, Builder $query)
    {
        $this->table = $table;
        $this->query = $query;
    }

    /**
     * Get the query.
     *
     * @return Builder
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Get the table.
     *
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }
}
