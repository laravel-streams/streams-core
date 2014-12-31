<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnHeader;

/**
 * Class GetColumnHeadingCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Column\Command
 */
class GetColumnHeadingCommandHandler
{

    /**
     * The header utility.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnHeader
     */
    protected $header;

    /**
     * Create a new GetColumnHeadingCommandHandler instance.
     *
     * @param ColumnHeader $header
     */
    public function __construct(ColumnHeader $header)
    {
        $this->header = $header;
    }

    /**
     * Handle the command.
     *
     * @param GetColumnHeadingCommand $command
     * @return null|string
     */
    public function handle(GetColumnHeadingCommand $command)
    {
        $table  = $command->getTable();
        $column = $command->getColumn();

        return $this->header->make($table, $column);
    }
}
