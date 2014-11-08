<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class HandleTableSortingCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTableSortingCommand
{

    /**
     * The table object.
     *
     * @var
     */
    protected $table;

    /**
     * The query builder object.
     *
     * @var
     */
    protected $query;

    /**
     * Create a new HandleTableSortingCommand instance.
     *
     * @param Table   $table
     * @param Builder $query
     */
    function __construct(Table $table, Builder $query)
    {
        $this->query = $query;
        $this->table = $table;
    }

    /**
     * Get the table object.
     *
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Get query builder object.
     *
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }
}
 