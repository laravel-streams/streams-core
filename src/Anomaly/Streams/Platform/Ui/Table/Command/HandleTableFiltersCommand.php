<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

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
     * @var
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
     * @param $ui
     * @param $query
     */
    function __construct($ui, $query)
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
     * @return mixed
     */
    public function getUi()
    {
        return $this->ui;
    }

}
 