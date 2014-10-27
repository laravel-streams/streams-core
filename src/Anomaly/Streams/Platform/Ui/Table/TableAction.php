<?php namespace Anomaly\Streams\Platform\Ui\Table;

/**
 * Class TableAction
 * A handler wrapper for closures.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TableAction
{
    /**
     * The table UI class.
     *
     * @var null
     */
    protected $ui = null;

    /**
     * The closure to run as the handler.
     *
     * @var callable
     */
    protected $closure;

    /**
     * Create a new TableAction instance.
     *
     * @param callable $closure
     */
    function __construct(\Closure $closure)
    {
        $this->closure = $closure;
    }

    /**
     * Handle the table action.
     */
    public function handle()
    {
        $handler = $this->closure;

        return $handler($this->ui);
    }

    /**
     * Set the table UI class.
     *
     * @param TableUi $ui
     * @return $this
     */
    public function setUi(TableUi $ui)
    {
        $this->ui = $ui;

        return $this;
    }
}
 