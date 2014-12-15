<?php namespace Anomaly\Streams\Platform\Ui\Table\Row\Command;

use Anomaly\Streams\Platform\Ui\Table\Row\RowFactory;

/**
 * Class LoadTableRowsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Row\Command
 */
class LoadTableRowsCommandHandler
{

    /**
     * The row factory.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Row\RowFactory
     */
    protected $factory;

    /**
     * Create a new LoadTableRowsCommandHandler instance.
     *
     * @param RowFactory $factory
     */
    public function __construct(RowFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Handle the command.
     *
     * @param LoadTableRowsCommand $command
     */
    public function handle(LoadTableRowsCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $entries = $table->getEntries();
        $columns = $table->getColumns();
        $buttons = $table->getButtons();
        $rows    = $table->getRows();

        foreach ($entries as $entry) {
            $row = $this->factory->make(compact('entry', 'columns', 'buttons'));

            $rows->push($row);
        }
    }
}
