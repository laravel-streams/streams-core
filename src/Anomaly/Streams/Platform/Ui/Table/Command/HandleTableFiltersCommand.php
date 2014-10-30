<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableUi;

/**
 * Class HandleTableFiltersCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTableFiltersCommand
{

    /**
     * The table UI object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\TableUi
     */
    protected $ui;

    /**
     * The query object. Likely a query builder.
     *
     * @var
     */
    protected $query;

    /**
     * Create a new HandleTableFiltersCommand instance.
     *
     * @param TableUi $ui
     * @param         $query
     */
    function __construct(TableUi $ui, $query)
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
     * @return TableUi
     */
    public function getUi()
    {
        return $this->ui;
    }
}
 