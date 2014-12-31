<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class HandleTablePostCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTablePostCommand
{

    /**
     * The table object.
     *
     * @var Table
     */
    protected $table;

    /**
     * Create a new HandleTablePostCommand instance.
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
