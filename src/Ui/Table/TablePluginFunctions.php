<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Table\Component\Column\Contract\ColumnInterface;
use Laracasts\Commander\CommanderTrait;

/**
 * Class TablePluginFunctions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TablePluginFunctions
{

    use CommanderTrait;

    /**
     * Return the table header for a column.
     *
     * @param Table           $table
     * @param ColumnInterface $column
     * @return string
     */
    public function columnHeader(Table $table, ColumnInterface $column)
    {
        return $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\Column\Command\GetColumnHeaderCommand',
            compact('table', 'column')
        );
    }

    /**
     * Return the value data for a column.
     *
     * @param Table           $table
     * @param ColumnInterface $column
     * @param                 $entry
     * @return string
     */
    public function columnValue(Table $table, ColumnInterface $column, $entry)
    {
        return $this->execute(
            'Anomaly\Streams\Platform\Ui\Table\Component\Column\Command\GetColumnValueCommand',
            compact('table', 'column', 'entry')
        );
    }
}
