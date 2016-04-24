<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnValue;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\Command\GetColumnValue;

/**
 * Class GetColumnValueHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Column\Command
 */
class GetColumnValueHandler
{

    /**
     * The value utility.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnValue
     */
    protected $value;

    /**
     * Create a new GetColumnValueHandler instance.
     *
     * @param ColumnValue $value
     */
    public function __construct(ColumnValue $value)
    {
        $this->value = $value;
    }

    /**
     * Handle the command.
     *
     * @param GetColumnValue $command
     * @return mixed
     */
    public function handle(GetColumnValue $command)
    {
        $entry  = $command->getEntry();
        $table  = $command->getTable();
        $column = $command->getColumn();

        return $this->value->make($table, $column, $entry);
    }
}
