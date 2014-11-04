<?php namespace Anomaly\Streams\Platform\Ui\Table\Event;

use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class AbstractTableEvent
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Event
 */
abstract class AbstractTableEvent
{

    /**
     * The table object.
     *
     * @var
     */
    protected $table;

    /**
     * Create a new table event instance.
     *
     * @param Table $table
     */
    function __construct(Table $table)
    {
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
}
 