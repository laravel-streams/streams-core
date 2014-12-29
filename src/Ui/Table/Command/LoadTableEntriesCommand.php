<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class LoadTableEntriesCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class LoadTableEntriesCommand
{

    /**
     * The table object.
     *
     * @var Table
     */
    protected $table;

    /**
     * Create a new LoadTableEntriesCommand instance.
     *
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * Get the table object.
     *
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }
}
