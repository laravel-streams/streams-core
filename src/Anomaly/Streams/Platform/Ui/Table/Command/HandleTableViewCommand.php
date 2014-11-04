<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class HandleTableViewCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTableViewCommand
{

    /**
     * The table UI object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Table
     */
    protected $ui;

    /**
     * The query object. Likely an eloquent query builder.
     *
     * @var
     */
    protected $query;

    /**
     * Create a new HandleTableViewCommand instance.
     *
     * @param Table $ui
     */
    function __construct(Table $ui, $query)
    {
        $this->ui    = $ui;
        $this->query = $query;
    }

    /**
     * Get the query object.
     *
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Get the table UI object.
     *
     * @return Table
     */
    public function getUi()
    {
        return $this->ui;
    }
}
 