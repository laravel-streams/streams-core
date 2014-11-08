<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class BuildTableColumnsCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableColumnsCommand
{

    /**
     * The table UI object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Table
     */
    protected $table;

    /**
     * The entry payload.
     *
     * @var
     */
    protected $entry;

    /**
     * Create a new BuildTableColumnsCommand instance.
     *
     * @param Table $table
     * @param         $entry
     */
    function __construct(Table $table, $entry)
    {
        $this->table    = $table;
        $this->entry = $entry;
    }

    /**
     * Get the table UI object.
     *
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Get the entry payload.
     *
     * @return mixed
     */
    public function getEntry()
    {
        return $this->entry;
    }
}
 