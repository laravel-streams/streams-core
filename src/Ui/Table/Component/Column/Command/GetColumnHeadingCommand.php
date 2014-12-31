<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Column\Contract\ColumnInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class GetColumnHeadingCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class GetColumnHeadingCommand
{

    /**
     * The table object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Table
     */
    protected $table;

    /**
     * The column object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Column\Contract\ColumnInterface
     */
    protected $column;

    /**
     * Create a new GetColumnHeadingCommand instance.
     *
     * @param Table           $table
     * @param ColumnInterface $column
     */
    function __construct(Table $table, ColumnInterface $column)
    {
        $this->table  = $table;
        $this->column = $column;
    }

    /**
     * Get the column object.
     *
     * @return ColumnInterface
     */
    public function getColumn()
    {
        return $this->column;
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
