<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class HandleTableActionCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTableActionCommand
{

    /**
     * The table object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Table
     */
    protected $table;

    /**
     * Create a new HandleTableActionCommand instance.
     *
     * @param Table $table
     */
    function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * Get the table UI class.
     *
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }
}
 